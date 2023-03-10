<?php

use App\Http\Controllers\TrangCaNhanController;
use App\Http\Controllers\SearchController;
use App\Models\baiviets;
use App\Models\binhluans;
use App\Models\chitietgiohangs;
use App\Models\chitiethoadonbans;
use App\Models\danhgias;
use App\Models\diachi;
use App\Models\giohangs;
use App\Models\hoadonbanhangs;
use App\Models\imagedts;
use App\Models\nguoidungs;
use App\Models\quanhuyens;
use App\Models\tinhthanhphos;
use App\Models\xaphuongs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Models\chitietdienthoais;
use App\Models\dienthoais;
use App\Http\Controllers\DangKyController;
use App\Http\Controllers\DangNhapController;
use App\Http\Controllers\DropDownController;
use App\Http\Controllers\ChiTietHoaDonController;



//Trang Chu
Route::get('/', function () {
    if(!isset($_COOKIE['is_logged'])) {
        setcookie('is_logged', 0, time() + 360000, '/');
      }

    return redirect('/TrangChu');
});
Route::get('DangXuat', function () {
    setcookie('is_logged', 0, time() - 360000, '/');
    setcookie('is_logged', 0, time() + 360000, '/');
    return redirect('/TrangChu');
})->name('DangXuat');
//Trang Chu cho guest
// Route::get('/TrangChu', function () {
//     $colors = chitietdienthoais::select('MaDT', 'BoNhoTrong', 'MauSac')->get();
//     $ctdts = chitietdienthoais::select('MaDT', 'BoNhoTrong', 'GiaTienBan')->groupBy('MaDT', 'BoNhoTrong', 'GiaTienBan')->inRandomOrder()->get();
//     $dts = dienthoais::get();
//     return view('TrangChu', array('ctdts' => $ctdts, 'dts' => $dts, 'colors' => $colors));
// })->name('TrangChu');

Route::get('/TrangChu', function () {
    if(!isset($_COOKIE['is_logged'])) {
        setcookie('is_logged', 0, time() + 360000, '/');
      }
    $colors = chitietdienthoais::select('MaDT', 'BoNhoTrong', 'MauSac')->get();
    $ctdts = chitietdienthoais::select('MaDT', 'BoNhoTrong', 'GiaTienBan')->groupBy('MaDT', 'BoNhoTrong', 'GiaTienBan')->inRandomOrder()->get();
    $dts = dienthoais::get();
    if (isset($_COOKIE['is_logged'])&&$_COOKIE['is_logged']==1) {
        $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
        $detailcart = chitietgiohangs::get();
        $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();

        return view(
            'TrangChu',
            array(
                'ctdts' => $ctdts,
                'dts' => $dts,
                'colors' => $colors,
                'user' => $user,
                'quantityphone' => $quantityphone,
                'detailcart' => $detailcart,
            )
        );
    } else {
        return view('TrangChu', array('ctdts' => $ctdts, 'dts' => $dts, 'colors' => $colors));
    }
})->name('TrangChu');

//Trang Dien Thoai Theo Hang
Route::get('DienThoai/{HangSX}', function ($HangSX) {
    $colors = chitietdienthoais::select('MaDT', 'BoNhoTrong', 'MauSac')->get();
    $ctdts = chitietdienthoais::select('MaDT', 'BoNhoTrong', 'GiaTienBan')->groupBy('MaDT', 'BoNhoTrong', 'GiaTienBan')->inRandomOrder()->get();
    $dts = dienthoais::where('HangSX','LIKE',"%{$HangSX}%")->get();
    if ($_COOKIE['is_logged']) {
        $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
        $detailcart = chitietgiohangs::get();
        $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();

        return view(
            'DienThoai',
            array(
                'ctdts' => $ctdts,
                'dts' => $dts,
                'colors' => $colors,
                'user' => $user,
                'quantityphone' => $quantityphone,
                'detailcart' => $detailcart,
            )
        );
    } else {
        return view('DienThoai', array('ctdts' => $ctdts, 'dts' => $dts, 'colors' => $colors));
    }

})->name('HangSX');

//Trang Dien Thoai
Route::get('TrangChu/DienThoai', function () {
    $colors = chitietdienthoais::select('MaDT', 'BoNhoTrong', 'MauSac')->get();
    $ctdts = chitietdienthoais::select('MaDT', 'BoNhoTrong', 'GiaTienBan')->groupBy('MaDT', 'BoNhoTrong', 'GiaTienBan')->inRandomOrder()->get();
    $dts = dienthoais::get();
    if ($_COOKIE['is_logged']) {
        $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
        $detailcart = chitietgiohangs::get();
        $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();

        return view(
            'DienThoai',
            array(
                'ctdts' => $ctdts,
                'dts' => $dts,
                'colors' => $colors,
                'user' => $user,
                'quantityphone' => $quantityphone,
                'detailcart' => $detailcart,
            )
        );
    } else {
        return view('DienThoai', array('ctdts' => $ctdts, 'dts' => $dts, 'colors' => $colors));
    }

})->name('TrangChu/DienThoai');
//Trang Chi Ti????t ??i????n Thoa??i
Route::get('/TrangChu/DienThoai/{id}/{rom}/{color}', function ($id, $rom, $color) {
    $thiscolorthisphone = imagedts::where('MaDT', '=', $id)->where('MauSac', '=', $color)->count();
    //ma??u cu??a t????t ca?? ca??c do??ng ??i????n thoa??i na??y
    $colorandrom = chitietdienthoais::where('MaDT', '=', $id)->select('MaDT', 'BoNhoTrong', 'MauSac')->groupBy('MaDT', 'BoNhoTrong', 'MauSac')->get();
    //ma??u ??i????n thoa??i ????????ng d????n hi??nh cu??a ??i????n thoa??i na??y
    $img = imagedts::where('MaDT', '=', $id)->where('MauSac', '=', $color)->get();
    // ti??m th??ng tin ??i??n thoa??i cu??a ??i????n thoa??i na??y
    $dt = dienthoais::where('MaDT', '=', $id)->first();
    //ti??m th??ng tin ??i????n  thoa??i na??y va?? co?? b???? nh???? trong t????ng ????ng 
    $ctdt = chitietdienthoais::where('MaDT', '=', $id)->where('BoNhoTrong', '=', $rom)->get();
    //nho??m t????t ca?? ca??c ??i????n thoa??i g????m ca??c th??ng tin nh?? ma?? ??i????n thoa??i b???? nh???? trong va?? gia?? ti????n ba??n
    $ctdts = chitietdienthoais::select('MaDT', 'BoNhoTrong', 'GiaTienBan')->where('MaDT', '=', $id)->groupBy('MaDT', 'BoNhoTrong', 'GiaTienBan')->get();
    //th??ng tin chi ti????t sa??n ph????m ??i????n thoa??i t????ng t???? 
    $detailproduct = chitietdienthoais::select('MaDT', 'BoNhoTrong', 'GiaTienBan')->groupBy('MaDT', 'BoNhoTrong', 'GiaTienBan')->inRandomOrder()->get();
    //ki????m t????t ca?? ??i????n thoa??i co?? sa??n ph????m t????ng t????
    $product = dienthoais::inRandomOrder()->get();
    //ma??u t????t ca?? sa??n ph????m
    $allcolor = chitietdienthoais::select('MaDT', 'BoNhoTrong', 'MauSac')->get();
    //d???? li????u ba??i vi????t cu??a m????u ??i????n thoa??i na??y
    $baiviets = baiviets::get();
    //l????y t????t ca?? ca??c do??ng ??a??nh gia?? sa??n ph????m
    $danhgias = danhgias::get();
    //l????y th??ng tin t????t ca?? ng??????i du??ng
    $nguoidungs = nguoidungs::get();
    //l????y t????t ca?? ca??c do??ng bi??nh lu????n sa??n ph????m
    $binhluans = binhluans::orderBy('created_at', 'desc')->get();
    if ($_COOKIE['is_logged']) {
        $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
        $detailcart = chitietgiohangs::get();
        $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
        return view(
            'ChiTietDienThoai',
            array(
                'dt' => $dt,
                'ctdt' => $ctdt,
                'color' => $color,
                'ctdts' => $ctdts,
                'img' => $img,
                'colorandrom' => $colorandrom,
                'detailproduct' => $detailproduct,
                'product' => $product,
                'allcolor' => $allcolor,
                'thiscolorthisphone' => $thiscolorthisphone,
                'user' => $user,
                'quantityphone' => $quantityphone,
                'detailcart' => $detailcart,
                'baiviets'=>$baiviets,
                'danhgias'=>$danhgias,
                'nguoidungs'=>$nguoidungs,
                'binhluans'=>$binhluans,
            )
        );
    } else {
        return view(
            'ChiTietDienThoai',
            array(
                'dt' => $dt,
                'ctdt' => $ctdt,
                'color' => $color,
                'ctdts' => $ctdts,
                'img' => $img,
                'colorandrom' => $colorandrom,
                'detailproduct' => $detailproduct,
                'product' => $product,
                'allcolor' => $allcolor,
                'thiscolorthisphone' => $thiscolorthisphone,
                'baiviets'=>$baiviets,
                'danhgias'=>$danhgias,
                'nguoidungs'=>$nguoidungs,
                'binhluans'=>$binhluans,
            )
        );
    }

})->name('DienThoai');
//trang ????ng ky??
Route::get('/DangKy', [DangKyController::class, 'create'])->name('DangKy');
//??i????u h??????ng routt ????ng ky??
Route::post('/DangKy', [DangKyController::class, 'store'])->name('save');
//trang dang nhap
Route::get('/DangNhap', [DangNhapController::class, 'show'])->name('DangNhap');
//??i????u h??????ng rouute  ????ng ky??
Route::post('/DangNhap', [DangNhapController::class, 'check'])->name('login');

//trang gio hang
Route::get('/GioHang', function () {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    $products = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailrowproducts = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    return view(
        'GioHang',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'products' => $products,
            'detailrowproducts' => $detailrowproducts,
            'detailcart' => $detailcart
        )
    );
})->name('GioHang');



Route::get('/Add/{id}/{rom}/{color}', function ($id, $rom, $color) {
    if (isset($_COOKIE['is_logged'])&&$_COOKIE['is_logged']==0)
    {
        return redirect('/DangNhap');
    }
    $mactdt = chitietdienthoais::where('MaDT', $id)->where('BoNhoTrong', $rom)->where('MauSac', $color)->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    $products = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailrowproducts = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    $check = false;
    $qty = 0;
    foreach ($detailcart as $item) {
        if ($item->MaGioHang == $detailrowproducts[0]->MaGioHang) {
            if ($item->MaCTDT == $mactdt[0]->MaCTDT) {
                $qty = $item->SL;
                $check = true;
                break;
            }
        }
    }

    if ($check) {
        $qty += 1;
        chitietgiohangs::where('MaCTDT', $mactdt[0]->MaCTDT)->update(['Sl' => $qty]);
    } else {
        chitietgiohangs::insert([
            'MaGioHang' => $detailrowproducts[0]->MaGioHang,
            'MaCTDT' => $mactdt[0]->MaCTDT,
            'MauSac' => $color,
            'SL' => 1,
            'BoNhotrong' => $rom,
        ]);
    }
    return redirect()->route('DienThoai', ['id' => $id, 'rom' => $rom, 'color' => $color]);
})->name('Add');

Route::get('/Buy/{id}/{rom}/{color}', function ($id, $rom, $color) {
    if (isset($_COOKIE['is_logged'])&&$_COOKIE['is_logged']==0)
    {
        return redirect('/DangNhap');
    }
    $mactdt = chitietdienthoais::where('MaDT', $id)->where('BoNhoTrong', $rom)->where('MauSac', $color)->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    $products = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailrowproducts = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    $check = false;
    $qty = 0;
    foreach ($detailcart as $item) {
        if ($item->MaGioHang == $detailrowproducts[0]->MaGioHang) {
            if ($item->MaCTDT == $mactdt[0]->MaCTDT) {
                $qty = $item->SL;
                $check = true;
                break;
            }
        }
    }

    if ($check) {
        $qty += 1;
        chitietgiohangs::where('MaCTDT', $mactdt[0]->MaCTDT)->update(['Sl' => $qty]);
    } else {
        chitietgiohangs::insert([
            'MaGioHang' => $detailrowproducts[0]->MaGioHang,
            'MaCTDT' => $mactdt[0]->MaCTDT,
            'MauSac' => $color,
            'SL' => 1,
            'BoNhotrong' => $rom,
        ]);
    }
    return redirect()->route('GioHang');
})->name('Buy');

// Route::get('dropdown', function () {
//     $counteries = tinhthanhphos::get(['tentinh', 'id']);

//     return view('dropdown', compact('counteries'));
// });
Route::post('api/fetch-state', [DropDownController::class, 'fatchState']);
Route::post('api/fetch-cities', [DropDownController::class, 'fatchCity']);
// Route::get('ok/', function () {
//     return 'phong';
// })->name('show-all-prescription');


Route::post('XacNhan', [ChiTietHoaDonController::class, 'check'])->name('XacNhanDonHang');


Route::get('phong', function () {
    $full = 'S???? 5 T?? Ngo??c V??n,Thi?? tr????n Vo?? Xu,Huy????n ??????c Linh,Ti??nh Bi??nh Thu????n';
    $f1 = Str::of($full)->before(','); //gbfdbfdb
    $f2 = Str::of($full)->after(','); ///Thi?? tr????n Vo?? Xu,??????c Linh, Bi??nh Thu????n
    $f3 = Str::of($f2)->before(','); //Thi?? tr????n Vo?? Xu
    $f4 = Str::of($f2)->after(','); //??????c Linh, Bi??nh Thu????n
    $f5 = Str::of($f4)->before(','); //??????c Linh
    $f6 = Str::of($f4)->after(','); // Bi??nh Thu????n
    return $f1 . ',' . $f3 . ',' . $f5 . ',' . $f6;
});

//Xac Nhan Don hang
Route::get('/XacNhan', function () {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    $products = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailrowproducts = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')
        ->join('chitietgiohangs', 'giohangs.MaGioHang', '=', 'chitietgiohangs.MaGioHang')->get();
    $address = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('diachis', 'nguoidungs.MaNguoiDung', '=', 'diachis.MaNguoiDung')->get();
    $province = tinhthanhphos::get(['tentinh', 'id']);
    $district = quanhuyens::get(['tenhuyen', 'id']);
    $ward = xaphuongs::get(['tenxa', 'id']);
    return view(
        'XacNhanDonHang',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'products' => $products,
            'detailrowproducts' => $detailrowproducts,
            'province' => $province,
            'address' => $address,
            'district' => $district,
            'ward' => $ward,
            'detailcart' => $detailcart,
        )
    );
})->name('XacNhan');

//Xac Nhan Don Thong Tin
Route::get('/XacNhanThongTin', function () {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    $products = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailrowproducts = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')
        ->join('chitietgiohangs', 'giohangs.MaGioHang', '=', 'chitietgiohangs.MaGioHang')->get();
    $address = diachi::where("MaNguoiDung", $_COOKIE['id'])->get();
    $province = tinhthanhphos::get(['tentinh', 'id']);
    $district = quanhuyens::get(['tenhuyen', 'id']);
    $ward = xaphuongs::get(['tenxa', 'id']);

    return view(
        'XacNhanThongTin',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'products' => $products,
            'detailrowproducts' => $detailrowproducts,
            'province' => $province,
            'address' => $address,
            'district' => $district,
            'ward' => $ward,
            'detailcart' => $detailcart,
        )
    );
})->name('XacNhanThongTin');

//Dat hang thanh Cong
Route::get('/DatHangThanhCong', function () {
    $price = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')
        ->join('chitietgiohangs', 'giohangs.MaGioHang', '=', 'chitietgiohangs.MaGioHang')->join('chitietdienthoais', 'chitietdienthoais.MaCTDT', '=', 'chitietgiohangs.MaCTDT')->get();
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    $products = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $date_array = getdate();
    $date_array = $date_array[0];
    $number = rand(0, 10000);
    $number = $date_array . $number;
    $current = Carbon::now();
    $totalprice = 0;
    foreach ($detailcart as $item) {
        if ($item->MaGioHang == $quantityphone[0]->MaGioHang) {
            foreach ($products as $item1) {
                if ($item->MaCTDT == $item1->MaCTDT)
                    $totalprice += $item->SL * $item1->GiaTienBan;
            }
        }
    }

    hoadonbanhangs::insert([
        'MaHoaDon' => $number,
        'NgayLap' => $current,
        'TongTien' => $totalprice,
        'TTDonHang' => 0,
        'MaNguoiDung' => $_COOKIE['id'],
    ]);
    foreach ($detailcart as $item) {
        if ($item->MaGioHang == $quantityphone[0]->MaGioHang) {
            foreach ($products as $item1) {
                if ($item->MaCTDT == $item1->MaCTDT) {
                    $date_array1 = getdate();
                    $date_array1 = $date_array1[0];
                    $number1 = rand(0, 10000);
                    $number1 = $date_array . $number1;
                    chitiethoadonbans::insert([
                        'MaCTHDBan' => $number1,
                        'MaHoaDon' => $number,
                        'SL' => $item->SL,
                        'GiaBan' => $item1->GiaTienBan,
                        'MaCTDT' => $item->MaCTDT,
                    ]);
                }
            }
        }
    }

    chitietgiohangs::where('MaGioHang', $quantityphone[0]->MaGioHang)->delete();
    return redirect()->route('ThongBao', ['total' => $totalprice]);

})->name('DatHangThanhCong');

Route::get('ThongBao/{total}', function ($total) {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    $products = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailrowproducts = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')
        ->join('chitietgiohangs', 'giohangs.MaGioHang', '=', 'chitietgiohangs.MaGioHang')->get();
    $address = diachi::where("MaNguoiDung", $_COOKIE['id'])->get();
    $province = tinhthanhphos::get(['tentinh', 'id']);
    $district = quanhuyens::get(['tenhuyen', 'id']);
    $ward = xaphuongs::get(['tenxa', 'id']);

    return view(
        'DatHangThanhCong',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'products' => $products,
            'detailrowproducts' => $detailrowproducts,
            'province' => $province,
            'address' => $address,
            'district' => $district,
            'ward' => $ward,
            'detailcart' => $detailcart,
            'total' => $total,
        )
    );
})->name('ThongBao');

//trang ca nhan
Route::get('TrangCaNhan', function () {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $detailcart = chitietgiohangs::get();
    $address = diachi::where("MaNguoiDung", $_COOKIE['id'])->get();
    $province = tinhthanhphos::get(['tentinh', 'id']);
    $district = quanhuyens::get(['tenhuyen', 'id']);
    $ward = xaphuongs::get(['tenxa', 'id']);
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();

    return view(
        'TrangCaNhan',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'detailcart' => $detailcart,
            'province' => $province,
            'address' => $address,
            'district' => $district,
            'ward' => $ward,
        )
    );
})->name('TrangCaNhan');
//trang qua??n ly?? ????n ha??ng
Route::get('QuanLyDonHang', function () {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $order = hoadonbanhangs::join('nguoidungs', 'nguoidungs.MaNguoiDung', '=', 'hoadonbanhangs.MaNguoiDung')->get();
    $detailorder = chitiethoadonbans::get();
    // $cart = giohangs::where("MaNguoiDung", $_COOKIE['id'])->get();

    $detailcart = chitietgiohangs::get();
    $phone = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();

    return view(
        'QuanLyDonHang',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'detailcart' => $detailcart,
            'order' => $order,
            'detailorder' => $detailorder,
            'phone' => $phone,
        )
    );
})->name('QuanLyDonHang');
//trang qua??n ly?? sa??n ph????m
Route::get('QuanLySanPham', function () {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $detailcart = chitietgiohangs::get();
    $phone = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();

    return view(
        'QuanLySanPham',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'detailcart' => $detailcart,
            'phone' => $phone,
        )
    );
})->name('QuanLySanPham');
//xem chi ti????t sa??n ph????m by admin
Route::get('XemChiTietSanPhamAdmin/{MaCTDT}', function ($MaCTDT) {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $detailcart = chitietgiohangs::get();
    $phone = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->where('chitietdienthoais.MaCTDT',$MaCTDT)->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();

    return view(
        'XemChiTietSanPhamAdmin',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'detailcart' => $detailcart,
            'phone' => $phone,
        )
    );
})->name('XemChiTietSanPhamAdmin');
//C????p Nh????t Th??ng Tin Sdt va?? Ho?? T??n
Route::post('CapNhatThongTin', [TrangCaNhanController::class, 'update'])->name('CapNhatThongTin');
//C????p Nh????t Th??ng Tin SDT va?? Ho?? T??n
Route::get('CapNhatDiaChi', function () {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $detailcart = chitietgiohangs::get();
    $address = diachi::where("MaNguoiDung", $_COOKIE['id'])->get();
    $province = tinhthanhphos::get(['tentinh', 'id']);
    $district = quanhuyens::get(['tenhuyen', 'id']);
    $ward = xaphuongs::get(['tenxa', 'id']);
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();

    return view(
        'ThayDoiDiaChi',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'detailcart' => $detailcart,
            'province' => $province,
            'address' => $address,
            'district' => $district,
            'ward' => $ward,
        )
    );
})->name('CapNhatDiaChi');
//C????p Nh????t Th??ng Tin ??i??a Chi??
Route::post('CapNhatDiaChi', [TrangCaNhanController::class, 'updateaddress'])->name('CapNhatDiaChi');


//C????p Nh????t Th??ng Tin M????t Kh????u
Route::get('CapNhatMatKhau', function () {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $detailcart = chitietgiohangs::get();
    $address = diachi::where("MaNguoiDung", $_COOKIE['id'])->get();
    $province = tinhthanhphos::get(['tentinh', 'id']);
    $district = quanhuyens::get(['tenhuyen', 'id']);
    $ward = xaphuongs::get(['tenxa', 'id']);
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();

    return view(
        'ThayDoiMatKhau',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'detailcart' => $detailcart,
            'province' => $province,
            'address' => $address,
            'district' => $district,
            'ward' => $ward,
        )
    );
})->name('CapNhatMatKhau');

//C????p Nh????t Th??ng Tin M????t Kh????u
Route::post('CapNhatMatKhau', [TrangCaNhanController::class, 'updatepassword'])->name('CapNhatMatKhau');

//xem li??ch s???? mua ha??ng
Route::get('LichSuMuaHang', function () {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $order = hoadonbanhangs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $detailorder = chitiethoadonbans::get();
    // $cart = giohangs::where("MaNguoiDung", $_COOKIE['id'])->get();

    $detailcart = chitietgiohangs::get();
    $phone = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();

    return view(
        'LichSuMuaHang',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'detailcart' => $detailcart,
            'order' => $order,
            'detailorder' => $detailorder,
            'phone' => $phone,
        )
    );
})->name('LichSuMuaHang');

//xem li??ch s???? mua ha??ng
Route::get('ChiTietDonHangAdmin/{MaDH}/{MaNguoiDung}', function ($MaDH,$MaNguoiDung) {
    $user=nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    //thoong tin nguoi dat don hang
    $user1 = nguoidungs::where("MaNguoiDung",$MaNguoiDung)->get();
    $order = hoadonbanhangs::where("MaHoaDon", $MaDH)->where('MaNguoiDung',$MaNguoiDung)->get();
    $detailorder = chitiethoadonbans::get();
    $address = diachi::where("MaNguoiDung", $MaNguoiDung)->get();
    $province = tinhthanhphos::get(['tentinh', 'id']);
    $district = quanhuyens::get(['tenhuyen', 'id']);
    $ward = xaphuongs::get(['tenxa', 'id']);
    $detailcart = chitietgiohangs::get();
    $phone = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung",$MaNguoiDung)->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    $rates = danhgias::get();
    return view(
        'ChiTietDonHangAdmin',
        array(
            'user' => $user,
            'user1' => $user1,
            'quantityphone' => $quantityphone,
            'detailcart' => $detailcart,
            'order' => $order,
            'detailorder' => $detailorder,
            'phone' => $phone,
            'MaDH' => $MaDH,
            'province' => $province,
            'address' => $address,
            'district' => $district,
            'ward' => $ward,
            'rates'=>$rates,
        )
    );
})->name('ChiTietDonHangAdmin');
//hu??y ????n ha??ng admin
Route::get('HuyDonHangAdmin/{MaDH}/{MaNguoiDung}', function ($MaDH,$MaNguoiDung) {
    $user=nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    //thoong tin nguoi dat don hang
    $user1 = nguoidungs::where("MaNguoiDung",$MaNguoiDung)->get();
    $order = hoadonbanhangs::where("MaHoaDon", $MaDH)->where('MaNguoiDung',$MaNguoiDung)->get();
    $detailorder = chitiethoadonbans::get();
    $address = diachi::where("MaNguoiDung", $MaNguoiDung)->get();
    $province = tinhthanhphos::get(['tentinh', 'id']);
    $district = quanhuyens::get(['tenhuyen', 'id']);
    $ward = xaphuongs::get(['tenxa', 'id']);
    $detailcart = chitietgiohangs::get();
    $phone = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung",$MaNguoiDung)->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    $rates = danhgias::get();
    return view(
        'HuyDonHangAdmin',
        array(
            'user' => $user,
            'user1' => $user1,
            'quantityphone' => $quantityphone,
            'detailcart' => $detailcart,
            'order' => $order,
            'detailorder' => $detailorder,
            'phone' => $phone,
            'MaDH' => $MaDH,
            'province' => $province,
            'address' => $address,
            'district' => $district,
            'ward' => $ward,
            'rates'=>$rates,
        )
    );
})->name('HuyDonHangAdmin');

//xem li??ch s???? mua ha??ng
Route::get('ChiTietDonHang/{MaDH}', function ($MaDH) {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $order = hoadonbanhangs::where("MaNguoiDung", $_COOKIE['id'])->where("MaHoaDon", $MaDH)->get();
    $detailorder = chitiethoadonbans::get();
    // $cart = giohangs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $address = diachi::where("MaNguoiDung", $_COOKIE['id'])->get();
    $province = tinhthanhphos::get(['tentinh', 'id']);
    $district = quanhuyens::get(['tenhuyen', 'id']);
    $ward = xaphuongs::get(['tenxa', 'id']);
    $detailcart = chitietgiohangs::get();
    $phone = dienthoais::join('chitietdienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    $rates = danhgias::get();
    return view(
        'ChiTietDonHang',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'detailcart' => $detailcart,
            'order' => $order,
            'detailorder' => $detailorder,
            'phone' => $phone,
            'MaDH' => $MaDH,
            'province' => $province,
            'address' => $address,
            'district' => $district,
            'ward' => $ward,
            'rates'=>$rates,
        )
    );
})->name('ChiTietDonHang');


//??a??nh gia?? sa??n ph????m

Route::get('DanhGiaSanPham/{MaCTDT}', function ($MaCTDT) {
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $phone = chitietdienthoais::where("chitietdienthoais.MaCTDT", $MaCTDT)->join('dienthoais', 'dienthoais.MaDT', '=', 'chitietdienthoais.MaDT')->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();
    return view(
        'DanhGiaSanPham',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'detailcart' => $detailcart,
            'phone' => $phone,
        )
    );
})->name('DanhGiaSanPham');

Route::post('api/star', [DropDownController::class, 'star']);
Route::get('danhgiathanhcong', function () {
    setcookie('start', 0, time() - 360000, '/');
    setcookie('mactdt',0, time() - 360000, '/');
    setcookie('noidung', 0, time() - 360000, '/');
    danhgias::create([
        'MaNguoiDung' => $_COOKIE['id'],
        'MaCTDT' => $_COOKIE['mactdt'],
        'SoSao' =>$_COOKIE['start'],
        'NoiDung' => $_COOKIE['noidung'],
    ]);
    $user = nguoidungs::where("MaNguoiDung", $_COOKIE['id'])->get();
    $detailcart = chitietgiohangs::get();
    $quantityphone = nguoidungs::where("nguoidungs.MaNguoiDung", $_COOKIE['id'])->join('giohangs', 'nguoidungs.MaNguoiDung', '=', 'giohangs.MaNguoiDung')->get();

    return view(
        'danhgiathanhcong',
        array(
            'user' => $user,
            'quantityphone' => $quantityphone,
            'detailcart' => $detailcart,
        )
    );
})->name('danhgiathanhcong');

//t??ng s???? l??????ng sa??n ph????m gio?? ha??ng
Route::post('api/up', [DropDownController::class, 'up']);
//gia??m s???? l??????ng sa??n ph????m gio?? ha??ng
Route::post('api/down', [DropDownController::class, 'down']);
//gia??m s???? l??????ng sa??n ph????m gio?? ha??ng
Route::post('api/delete', [DropDownController::class, 'delete']);
//bi??nh lu????n sa??n ph????m
Route::post('api/comment', [DropDownController::class, 'comment']);
//C????p Nh????t Th??ng Tin ????n ha??ng
Route::post('CapNhatThongTinDonHang', [ChiTietHoaDonController::class, 'update'])->name('CapNhatThongTinDonHang');
//Hu??y ????n ha??ng
Route::post('HuyDonHang', [ChiTietHoaDonController::class, 'delete'])->name('HuyDonHang');
//C????p Nh????t Th??ng Tin sa??n ph????m
Route::post('CapNhatThongTinSP', [ChiTietHoaDonController::class, 'updatesanpham'])->name('CapNhatThongTinSP');
//ti??m ki????m sa??n ph????m
Route::post('TimKiem', [SearchController::class, 'search'])->Name('TimKiem');