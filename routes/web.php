<?php

use App\Http\Controllers\C_Buku;
use App\Http\Controllers\C_ContentMenu;
use App\Http\Controllers\C_Jurnal;
use App\Http\Controllers\C_JenisMedia;
use App\Http\Controllers\C_JenisMediaProperties;
use App\Http\Controllers\C_Kategori;
use App\Http\Controllers\C_Landing;
use App\Http\Controllers\C_News;
use App\Http\Controllers\C_Nusantara;
use App\Http\Controllers\C_Menu;
use App\Http\Controllers\C_Penerbit;
use App\Http\Controllers\C_Pengguna;
use App\Http\Controllers\C_Permission;
use App\Http\Controllers\C_Role;
use App\Http\Controllers\C_SubMenu;
use App\Http\Controllers\C_Unit;
use App\Http\Controllers\C_Welcome;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', [C_Landing::class, 'index']);
Route::get('news-all', [C_Landing::class, 'semuaBerita']);
Route::get('news-find', [C_Landing::class, 'cariBerita']);
Route::get('news/{url}', [C_Landing::class, 'berita']);
Route::get('subMenu/{url}', [C_Landing::class, 'subMenu']);
Route::get('jurnal-all', [C_Landing::class, 'semuaJurnal']);
Route::get('tentang-kami', [C_Landing::class, 'tentangKami']);
Route::get('jurnal-find', [C_Landing::class, 'cariJurnal']);
Route::get('jurnal-kategori/{url}', [C_Landing::class, 'jurnalKategori']);
Route::get('jurnal-detail/{url}', [C_Landing::class, 'jurnalDetail']);
Route::get('book-all', [C_Landing::class, 'semuaBuku']);
Route::get('book-find', [C_Landing::class, 'cariBuku']);
Route::get('book-kategori/{url}', [C_Landing::class, 'bukuKategori']);
Route::get('buku-detail/{url}', [C_Landing::class, 'bukuDetail']);
Route::get('/view-pdf/{filename}', [C_Landing::class, 'show'])->name('pdf.view');
Route::post('evaluationDownload', [C_Landing::class, 'evaluationDownload'])->name('evaluationDownload');


Route::middleware('auth')->group(function () {
    Route::get('bookmark', [C_Landing::class, 'bookmark']);
    Route::post('bookmarkUpdate', [C_Landing::class, 'bookmarkUpdate']);
    Route::get('dashboard', [C_Welcome::class, 'index'])->name('welcome');
    Route::get('phpinfo', [C_Welcome::class, 'show'])->name('phpinfo');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('NusantaraSelect',           [C_Nusantara::class, 'NusantaraSelect'])->name('NusantaraSelect');

    Route::resource('permission',    C_Permission::class);
    Route::get('getPermission',     [C_Permission::class, 'getPermission'])->name('getPermission');
    Route::post('permissionDelete', [C_Permission::class, 'destroy'])->name('permissionDelete');

    Route::resource('kategori',    C_Kategori::class);
    Route::get('getKategori',     [C_Kategori::class, 'getKategori'])->name('getKategori');
    Route::post('kategoriDelete', [C_Kategori::class, 'destroy'])->name('kategoriDelete');
   
    Route::resource('menu',    C_Menu::class);
    Route::get('getMenu',     [C_Menu::class, 'getMenu'])->name('getMenu');
    Route::post('menuDelete', [C_Menu::class, 'destroy'])->name('menuDelete');
   
    Route::resource('subMenu',    C_SubMenu::class);
    Route::get('getSubMenu/{id?}',     [C_SubMenu::class, 'getSubMenu'])->name('getSubMenu');
    Route::post('subMenuDelete', [C_SubMenu::class, 'destroy'])->name('subMenuDelete');

    Route::resource('roles',     C_Role::class);
    Route::get('getRoles',      [C_Role::class, 'getRoles'])->name('getRoles');
    Route::get('getRoleShow',   [C_Role::class, 'getRoleShow'])->name('getRoleShow');
    Route::post('rolesDelete',  [C_Role::class, 'destroy'])->name('rolesDelete');
    Route::get('role.change',   [C_Role::class, 'change'])->name('role.change');

    Route::resource('pengguna',        C_Pengguna::class);
    Route::get('cekPassword',         [C_Pengguna::class, 'checkPassword'])->name('cekPassword');
    Route::get('getPengguna',         [C_Pengguna::class, 'getPengguna'])->name('getPengguna');
    Route::post('PenggunaDelete',     [C_Pengguna::class, 'destroy'])->name('PenggunaDelete');
    Route::get('EditPengguna',        [C_Pengguna::class, 'editPengguna'])->name('EditPengguna');
    Route::put('UpdatePengguna/{id}', [C_Pengguna::class, 'updatePengguna'])->name('update.Pengguna');

    Route::resource('penerbit',        C_Penerbit::class);
    Route::get('getPenerbit',         [C_Penerbit::class, 'getPenerbit'])->name('getPenerbit');
    Route::post('penerbitDelete',     [C_Penerbit::class, 'destroy'])->name('penerbitDelete');
    Route::get('EditPenerbit',        [C_Penerbit::class, 'editPenerbit'])->name('EditPenerbit');
    Route::put('updatePenerbit/{id}', [C_Penerbit::class, 'updatePenerbit'])->name('update.penerbit');
    Route::get('getPenerbitAutoCompl', [C_Penerbit::class, 'getPenerbitAutoCompl'])->name('getPenerbitAutoCompl');

    Route::resource('buku',          C_Buku::class);
    Route::get('getBuku',           [C_Buku::class, 'getBuku'])->name('getBuku');
    Route::post('bukuDelete',       [C_Buku::class, 'destroy'])->name('bukuDelete');

    Route::resource('jurnal',          C_Jurnal::class);
    Route::get('getJurnal',           [C_Jurnal::class, 'getJurnal'])->name('getJurnal');
    Route::post('jurnalDelete',       [C_Jurnal::class, 'destroy'])->name('jurnalDelete');
    Route::post('updatePengarang',    [C_Jurnal::class, 'updatePengarang'])->name('updatePengarang');
    Route::post('delPengarang',       [C_Jurnal::class, 'deletePengarang'])->name('delPengarang');
    Route::get('jurnalCek',           [C_Jurnal::class, 'jurnalCek'])->name('jurnalCek');
    Route::get('tekku',               [C_Jurnal::class, 'tekku'])->name('tekku');

    Route::resource('berita',          C_News::class);
    Route::get('getBerita',           [C_News::class, 'getBerita'])->name('getBerita');
    Route::post('upload-image',       [C_News::class, 'uploadImage'])->name('upload-image');
    Route::post('beritaDelete',       [C_News::class, 'destroy'])->name('beritaDelete');
    
    Route::resource('contentMenu',     C_ContentMenu::class);
    Route::get('getContentMenu',      [C_ContentMenu::class, 'getContentMenu'])->name('getContentMenu');
    Route::post('upload-image-CM',    [C_ContentMenu::class, 'uploadImage'])->name('upload-image');
    Route::post('ContentMenuDelete',  [C_ContentMenu::class, 'destroy'])->name('ContentMenuDelete');
    Route::get('createCM/{id?}',      [C_ContentMenu::class, 'createCM'])->name('createCM');

    Route::resource('unit',     C_Unit::class);
    Route::get('getUnit',      [C_Unit::class, 'getUnit'])->name('getUnit');
    Route::post('UnitDelete',  [C_Unit::class,'destroy'])->name('UnitDelete');

    Route::resource('jenisMedia',    C_JenisMedia::class);
    Route::get('getjenisMedia',     [C_JenisMedia::class, 'getjenisMedia'])->name('getjenisMedia');
    Route::post('jenisMediaDelete', [C_JenisMedia::class, 'destroy'])->name('jenisMediaDelete');

    Route::resource('jenisMediaProperties',          C_JenisMediaProperties::class);
    Route::get('getjenisMediaProperties/{id?}',     [C_JenisMediaProperties::class, 'getjenisMediaProperties'])->name('getjenisMediaProperties');
    Route::post('jenisMediaPropertiesDelete',       [C_JenisMediaProperties::class, 'destroy'])->name('jenisMediaPropertiesDelete');
    Route::get('statusJenisMediaProperties',        [C_JenisMediaProperties::class, 'statusJenisMediaProperties'])->name('statusJenisMediaProperties');
    Route::get('isCekJenisMedia',                   [C_JenisMediaProperties::class, 'isCekJenisMedia'])->name('isCekJenisMedia');

});

require __DIR__ . '/auth.php';
