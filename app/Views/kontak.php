<?= $this->extend('template'); ?>

<?= $this->section('content'); ?>
<?php $validation = \Config\Services::validation(); ?>
<!-- contact form -->
<div class="contact-from-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="form-title">
                    <?= $kontak[0]['textKontak']; ?>
                </div>

                <?php if (session()->getFlashdata('berhasil')) : ?>
                    <div class="alert alert-success alert-close" role="alert">
                        <?= session()->getFlashdata('berhasil') ?>
                    </div>
                <?php endif ?>
                <?php if (session()->getFlashdata('gagal')) : ?>
                    <div class="alert alert-danger alert-close" role="alert">
                        <?= session()->getFlashdata('gagal') ?>
                    </div>
                <?php endif ?>


                <!-- error -->
                <?php if (session('validation')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <ul>
                            <?php foreach (session('validation')->getErrors() as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>
                <!-- end error -->

                <div id="form_status"></div>
                <div class="contact-form">
                    <form method="POST" action="<?php echo base_url('kontak/sendEmail'); ?>" id="fruitkha-contact" onSubmit="return valid_datas( this );">
                        <?= csrf_field(); ?>
                        <p>
                            <input type="text" placeholder="Name" name="name" id="name" value="<?= set_value('name'); ?>">
                            <input type="email" placeholder="Email" name="email" id="email" value="<?= set_value('email'); ?>">
                        </p>
                        <p>
                            <input type="tel" placeholder="Phone" name="phone" id="phone" value="<?= set_value('phone'); ?>">
                            <input type="text" placeholder="Subject" name="subject" id="subject" value="<?= set_value('subject'); ?>">
                        </p>
                        <p><textarea name="message" id="message" cols="30" rows="10" placeholder="Message"><?= set_value('message'); ?></textarea></p>
                        <input type="hidden" name="token" value="FsWga4&@f6aw" />
                        <p><input type="submit" value="Submit"></p>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-form-wrap">
                    <div class="contact-form-box">
                        <h4><i class="fas fa-map"></i> Alamat Kantor</h4>
                        <p><?= $kontak_api['alamat']; ?></p>
                    </div>
                    <div class="contact-form-box">
                        <h4><i class="far fa-clock"></i> Jam Operasional</h4>
                        <p><?= $kontak_api['jamOperasional']; ?></p>
                    </div>
                    <div class="contact-form-box">
                        <h4><i class="fas fa-address-book"></i> Kontak</h4>
                        <p><?= $kontak_api['kontak']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end contact form -->

<!-- find our location -->
<div class="find-location blue-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <p> <i class="fas fa-map-marker-alt"></i> Lokasi </p>
            </div>
        </div>
    </div>
</div>
<!-- end find our location -->

<!-- google map section -->
<div class="embed-responsive embed-responsive-21by9">

    <iframe src="<?= $kontak_api['map']; ?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d3965.7449469111266!2d106.8249974147695!3d-6.297209695442388!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x2e69ede4f463b2fd%3A0x6695c51d1ee5905c!2sPT.%20DELTA%20FOOD%20DISTRIBUSI%2C%204%2C%20Jl.%20Kebagusan%20Raya%20No.2%2C%20RT.4%2FRW.1%2C%20Kebagusan%2C%20Ps.%20Minggu%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2012550!3m2!1d-6.297208599999999!2d106.8271633!5e0!3m2!1sid!2sid!4v1686107073079!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
</div>
<!-- end google map section -->
<?= $this->endSection('content'); ?>