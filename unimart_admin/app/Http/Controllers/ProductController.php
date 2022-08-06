<?php

namespace App\Http\Controllers;

use App\Components\CategoryBuilder;
use App\Product;
use App\ProductCat;
use App\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $htmlSelectCats = '';
    private $categoryIds = array();
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }
    // Nhóm các hàm chính
    function list(Request $request)
    {
        $perPage = 10;
        $available_count = Product::where('qty', '>', 0)->get()->count();
        $sold_out_count = Product::where('qty', '=', 0)->get()->count();
        $trash_count = Product::onlyTrashed()->get()->count();
        // Trả về keyword
        $input = $request->input();
        $keyword = '';
        if (isset($input['keyword'])) {
            $keyword = $input['keyword'];
        }
        // Trả về danh sách id của các tác giả có tên chứa keyword
        $list_author_ids = [];
        $authors = User::where('name', 'LIKE', "%{$keyword}%")->get();
        foreach ($authors as $author) {
            $list_author_ids[] = $author->id;
        }
        // Trả về danh sách id các danh mục có tên chứa keyword
        $list_categories_ids = [];
        $categories = ProductCat::where('name', 'LIKE', "%{$keyword}%")->get();
        foreach ($categories as $category) {
            $list_categories_ids[] = $category->id;
        }
        // Câu truy vấn chung theo keyword
        $products = Product::where(function ($query) use ($keyword, $list_author_ids, $list_categories_ids) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%")
                ->orWhere('summary', 'LIKE', "%{$keyword}%")
                ->orWhere('content', 'LIKE', "%{$keyword}%")
                ->orWhereIn('cat_id', $list_categories_ids)
                ->orWhereIn('user_id', $list_categories_ids);
        });
        // Xử lý kết quả trả về theo giá trị của viết status
        $status = 'available';
        if ($request->input('status') != null) {
            $status = $request->input('status');
        }

        if ($status == 'available') {
            $products = $products->where('qty', '>', 0)->paginate($perPage);
        } elseif ($status == 'sold_out') {
            $products = $products->where('qty', '=', 0)->paginate($perPage);
        } elseif ($status == 'trash') {
            $products = $products->onlyTrashed()->paginate($perPage);
        }
        return view('admin.product.list', compact('products', 'available_count', 'sold_out_count', 'trash_count'));
    }

    function add()
    {
        $users = User::get();
        $htmlOptions = '';
        $data = ProductCat::get();
        $builder = new CategoryBuilder($data);
        if (ProductCat::count() > 0) {
            $htmlOptions = $builder->categoriesMaker();
        }
        return view('admin.product.add', compact('htmlOptions', 'users'));
    }

    function update($id)
    {
        $product = Product::find($id);
        $users = User::get();
        $htmlOptions = '';
        $data = ProductCat::get();
        $builder = new CategoryBuilder($data);
        if (ProductCat::count() > 0) {
            $htmlOptions = $builder->categoriesMaker($product->cat_id);
        }
        return view('admin.product.update', compact('htmlOptions', 'users', 'product'));
    }

    function store(Request $request)
    {
        // Validation
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'summary' => 'required|string|max:1000',
                'description' => 'required|string|max:2000',
                'content' => 'required|string|min:100',
                'user_id' => 'required',
                'cat_id' => 'required',
                'price' => 'required',
                'old_price' => 'required',
                'qty' => 'required',
                'thumbnail' => 'required',
                'slug' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute bắt buộc là chuỗi',
                'max' => ':attribute có độ dài không được vượt quá :max ký tự',
                'min' => ':attribute có độ dài không được ít hơn :min ký tự'
            ],
            [
                'name' => 'Tên sản phẩm',
                'summary' => 'Tóm tắt sản phẩm',
                'description' => 'Miêu tả sản phẩm',
                'content' => 'Nội dung thông tin sản phẩm',
                'user_id' => 'Người tạo sản phẩm',
                'cat_id' => 'Danh mục sản phẩm',
                'price' => 'Giá sản phẩm',
                'old_price' => 'Giá cũ của sản phẩm',
                'qty' => 'Số lượng sản phẩm',
                'thumbnail' => 'Ảnh đại diện sản phẩm',
                'slug' => 'Slug'
            ]
        );
        $status_name = 'error';
        $message = "Không có thay đổi nào được diễn ra";
        $input = $request->input();
        $action = $input['action'];
        if (isset($input['product_id'])) {
            $product_id = $input['product_id'];
        }

        if ($action == 'update') {
            Product::find($product_id)->update($input);
            $status_name = 'success';
            $message = "Cập nhật thông tin sản phẩm thành công";
        } elseif ($action == 'add') {
            Product::create($input);
            $status_name = 'success';
            $message = "Thêm sản phẩm thành công";
        }
        return redirect()->route('admin.product.list')->with($status_name, $message);
    }

    function delete($id)
    {
        Product::destroy($id);
        return redirect(route('admin.product.list') . '?status=available')->with('success', 'Bạn đã đưa bản ghi vào thùng rác thành công!');
    }

    function restore($id)
    {
        Product::onlyTrashed()->where('id', $id)->restore();
        return redirect(url()->previous())->with('success', 'Bạn đã khôi phục bản ghi thành công!');
    }

    function permantly_del($id)
    {
        Product::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect(url()->previous())->with('success', 'Bạn đã xóa vĩnh viễn bản ghi thành công!');
    }

    // Nhóm các hàm liên quan đến danh mục

    function listCat()
    {
        $perPage = 5;
        $htmlOptions = '';
        $categoryIds =  [];
        $data = ProductCat::get();
        $builder = new CategoryBuilder($data);
        if (ProductCat::count() > 0) {
            $htmlOptions = $builder->categoriesMaker();
            $categoryIds =  $builder->categoryIdsMaker();
        }
        $categories = ProductCat::find($categoryIds)->sortBy(function ($category, $key) use ($categoryIds) {
            return array_search($category->id, $categoryIds);
        })->paginate($perPage);
        return view('admin.product.category.list', compact('categories', 'htmlOptions', 'perPage'));
    }

    function addCat(Request $request)
    {
        $request->validate(
            [
                'name' => ['required']
            ],
            [
                'required' => ':attribute không được để trống'
            ],
            [
                'name' => 'Tên danh mục sản phẩm'
            ]
        );
        $input = $request->input();
        ProductCat::create($input);
        return redirect()->route('admin.product.category.list')->with('success', 'Thêm danh mục sản phẩm thành công');
    }

    function updateCat($cat_id)
    {
        $category =  ProductCat::find($cat_id);
        $htmlOptions = '';
        $data = ProductCat::get();
        $builder = new CategoryBuilder($data);
        if (ProductCat::count() > 0) {
            $htmlOptions = $builder->categoriesMaker($category->parent_id);
        }
        return view('admin.product.category.update', compact('category', 'htmlOptions'));
    }

    function storeCat(Request $request)
    {
        $request->validate(
            [
                'name' => ['required'],
                'slug' => ['required']
            ],
            [
                'required' => ':attribute không được để trống'
            ],
            [
                'name' => 'Tên danh mục sản phẩm',
                'slug' => 'Slug'
            ]
        );
        $input = $request->input();
        $input['parent_id'] == '' ? null : $input['parent_id'];
        $product_cat_id = $input['product_cat_id'];
        ProductCat::find($product_cat_id)->update($input);
        return redirect()->route('admin.product.category.list')->with('success', 'Cập nhật danh mục bài viết thành công');
    }

    function deleteCat($cat_id)
    {
        ProductCat::destroy($cat_id);
        return redirect(url()->previous())->with('success', 'Xóa danh mục sản phẩm thành công');
    }

    // Hàm xử lý theo nhóm

    function action(Request $request)
    {
        $status_name = '';
        $message = '';
        $input = $request->input();
        $product_ids = [];
        if (isset($input['product_ids'])) {
            $product_ids = $input['product_ids'];
        }
        if (!empty($product_ids)) {
            $opt = $input['opt'];
            if ($opt == 'delete') {
                Product::destroy($product_ids);
                $status_name = "success";
                $message = "Đưa các sản phẩm vào thùng rác thành công!";
            } elseif ($opt == 'recover') {
                Product::onlyTrashed()->whereIn('id', $product_ids)->restore();
                $status_name = "success";
                $message = "Khôi phục các sản phẩm thành công!";
            } elseif ($opt == 'permantly_del') {
                Product::onlyTrashed()->whereIn('id', $product_ids)->forceDelete();
                $status_name = "success";
                $message = "Xóa vĩnh viễn các sản phẩm thành công!";
            }
        } else {
            $status_name = "error";
            $message = "Bạn phải chọn ít nhất một sản phẩm!";
        }
        return redirect(url()->previous())->with($status_name, $message);
    }
}
