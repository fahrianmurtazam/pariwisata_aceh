<?php
    include("koneksi.php");

    $nama= "";
    $noHP= "";
    $jmlPeserta= "";
    $jmlHari= "";
    $hrgPaket= "";
    $succes="";
    $error="";

    // menangkap id untuk edit & delete data
    if(isset($_GET['op'])){
        $op = $_GET['op'];
    } else {
        $op = "";
    }

    // untuk edit data
    if($op == "edit"){
        $id = $_GET['id'];
        $sql = "SELECT * FROM pesanan WHERE id ='$id'";
        $query = mysqli_query($koneksi, $sql);
        $data = mysqli_fetch_assoc($query);
        $nama = $data['nama'];
        $noHP = $data['noHP'];
        $jmlPeserta = $data['jmlPeserta'];
        $jmlHari = $data['jmlHari'];  
        $services = $data['services'];  
        $hrgPaket = $data["hrgPaket"];

        if($nama == ""){
            $error = "Data tidak ditemukan";
        }
    }
    
    // untuk delete data
    if($op == "delete"){
        $id = $_GET['id'];
        $sql = "DELETE FROM pesanan WHERE id ='$id'";
        $query = mysqli_query($koneksi, $sql);
        if($query){
            $succes = "Data berhasil dihapus";
        } else {
            $error = "Data gagal dihapus";
    }
}

    // cek apakah tombol sudah di klik
    if(isset($_POST['submit'])){
        // ambil data dari form
        $nama = $_POST['nama'];
        $noHP = $_POST['noHP'];
        $jmlPeserta = $_POST['jmlPeserta'];
        $jmlHari = $_POST['jmlHari'];  
        $hrgPaket = $_POST["hrgPaket"];

    // data input chekbox
    if (isset($_POST['services'])) {
        $services = $_POST['services'];
        // Pastikan data yang diterima adalah array
        if (is_array($services)) {
            // Gabungkan nilai array menjadi string dengan koma sebagai delimiter
            $service = implode(',', $services);
            // Escaping untuk mencegah SQL Injection
            $service = $koneksi->real_escape_string($service);
        }

        // untuk update data
        if($op == "edit"){
            $sql = "UPDATE pesanan SET nama ='$nama', noHP ='$noHP', jmlPeserta = '$jmlPeserta', jmlHari='$jmlHari', services='$service', hrgPaket='$hrgPaket' WHERE id='$id'";
            $query = mysqli_query($koneksi, $sql);
            if($query){
                $succes = "Data berhasil diupdate.";
            } else {
                $error = "Data gagal diupdate";
            }
        } else { // untuk tambah data
            // buat query
            $sql = "INSERT INTO pesanan (nama, noHP, jmlPeserta, jmlHari, services, hrgPaket) VALUES ('$nama', '$noHP', '$jmlPeserta', '$jmlHari', '$service', '$hrgPaket')";
            // eksekusi query
            $query = mysqli_query($koneksi, $sql);

            // notif tambah data
            if($query){
                $succes = "Data berhasil dikirim.";
            } else {
                $error = "Gagal mengirim data";
            }
        }
    }
}
?>



<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Buat pesanan</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div class="card pb-5 mx-auto" style="width: 70rem;">
            <div class="card-body">
            <a href="../" class="card-link d-block mt-2 fs-5">&laquo; Kembali ke halaman utama<a>
            <h3 class="text-center">Buat Pesanan</h3>
        </div>
        <div class="container">
            <?php
            if($error){
            ?>
                <div class="alert alert-danger" role="alert">
                <?php echo $error?>;
                </div>
            <?php
                header("refresh:2;url=data.php");
            }
            ?>

            <?php
            if($succes){
            ?>
                <div class="alert alert-success" role="alert">
                <?php echo $succes?>;
                </div>
            <?php
                header("refresh:2;url=data.php");
            }
            ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pemesan</label>
                <input type="text" class="form-control" name="nama" id="nama" required value="<?php echo $nama ?>">
            </div>
            <div class="mb-3">
                <label for="noHP" class="form-label">Nomor HP</label>
                <input type="text" class="form-control" name="noHP" id="noHP" required value="<?php echo $noHP ?>">
            </div>
            <div class="mb-3">
                <label for="jmlPeserta" class="form-label">Jumlah peserta</label>
                <input type="number" class="form-control" name="jmlPeserta" id="jmlPeserta" required value="<?php echo $jmlPeserta ?>">
            </div>
            <div class="mb-3">
                <label for="jmlHari" class="form-label">waktu pelaksanaan perjalan ( /hari)</label>
                <input type="number" class="form-control" name="jmlHari" id="jmlHari" required value="<?php echo $jmlHari ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Paket pelayanan : ( ❗ wajib dipilih)</label>
                <div class="d-flex align-items-center justify-content-evenly ">
                <p class="align-self-center service">penginapan (Rp 1000.000) :</p>
                <input type="checkbox" name="services[]" value="penginapan (Rp 1000.000)" class="mb-1">
                </div>
                <div class="d-flex align-items-center justify-content-evenly ">
                <p class="align-self-center service">transportasi (Rp 1.200.000) :</p>
                <input type="checkbox" name="services[]" value="transportasi (Rp 1.200.000)" class="mb-1">
                </div>
                <div class="d-flex align-items-center justify-content-evenly ">
                <p class="align-self-center service">service/makan (Rp 500.000) :</p>
                <input type="checkbox" name="services[]" value="makan (Rp 500.000)" class="mb-1">
                </div>
            </div>
            
            <div class="mb-5">
                <label for="hrgPaket" class="form-label">Harga paket perjalanan</label>
                <input type="text" class="form-control" name="hrgPaket" id="hrgPaket" readonly>
            </div>
            <button type="button" id="hitungBtn" class="btn px-5 btn-success">Cek Harga</button>
            <button type="submit" name="submit"  value="submit data" class="btn px-5 mx-2 btn-primary">Submit</button>
        </form>
        </div>
    </div>

    <div class="card px-5 py-3 mt-5">
        <div class="card-body">
            <h3>Data Pesanan</h3>
        </div>
        <table class="table table-striped">
  <thead>
    <tr class="text-center">
      <th scope="col">No</th>
      <th scope="col">Nama</th>
      <th scope="col">No HP</th>
      <th scope="col">Jumlah peserta</th>
      <th scope="col">Jumlah hari</th>
      <th scope="col">Services</th>
      <th scope="col">Harga paket</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT  id, nama, noHP, jmlPeserta, jmlHari, services, hrgPaket FROM pesanan";
    $query = mysqli_query($koneksi, $sql);
    $no = 1;
    ?>
    <?php
    while ($data = mysqli_fetch_assoc($query)) {
        $id = $data['id'];
        $nama = $data['nama'];
        $noHP = $data['noHP'];
        $jmlPeserta = $data['jmlPeserta'];
        $jmlHari = $data['jmlHari'];  
        $services = $data['services'];  
        $hrgPaket = $data["hrgPaket"];
    ?>
        <tr>
        <th scope="row"><?php echo $no++ ?></th> 
        <td scope="row"><?php echo $nama ?></td> 
        <td scope="row"><?php echo $noHP ?></td> 
        <td class="text-center" scope="row"><?php echo $jmlPeserta ?></td> 
        <td class="text-center" scope="row"><?php echo $jmlHari ?></td> 
        <td scope="row"><?php echo $services ?></td>
        <td scope="row"><?php echo "Rp ".$hrgPaket ?></td>

        <td class="d-flex gap-2" scope="row">
            <a href="data.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn badge btn-warning">Edit</button></a>
            <a href="data.php?op=delete&id=<?php echo $id?>" onclick="return confirm('yakin ingin menghapus data ?')"><button type="button" class="btn badge btn-danger">Delete</button></a>
        </td>
        </tr>
    <?php    
    } 
    ?>
    </tbody>
</table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
// untuk menghitung harga Paket pariwisata
const penginapan = 1000000;
const transportasi = 1200000;
const makan = 500000; 
function hitungPelayanan() {
            return penginapan + transportasi + makan;  
        } 

    // Fungsi untuk menghitung total harga paket
    function hitungTotalHarga(hari, peserta) {
            const pelayanan = hitungPelayanan();
            return hari * peserta * pelayanan;
        }

    // Fungsi untuk memperbarui total harga di input field
    function updateHargaPaket() {
            const hari = document.getElementById("jmlHari").value;
            const peserta = document.getElementById("jmlPeserta").value;
            const totalHarga = hitungTotalHarga(hari, peserta);
            document.getElementById("hrgPaket").value = totalHarga;
        }
    
    // Fungsi untuk mengaitkan event pada tombol
    function setupEventListeners() {
        document.getElementById("hitungBtn").addEventListener("click", updateHargaPaket);
    }

    // Set up event listeners saat halaman dimuat
    window.onload = setupEventListeners;
</script>
</body>
</html>