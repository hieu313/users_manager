<div style="width:600px; padding:20px 30px; text-align:center ;margin:0 auto">
    <h2>Lỗi Liên Quan Đến CSDL</h2>
    <hr/>
    <p> <?php echo $exeption->getMessage(); ?> </p>
    <p>File: <?php echo $exeption->getFile(); ?> </p>
    <p>Line: <?php echo $exeption->getLine(); ?> </p>
</div>