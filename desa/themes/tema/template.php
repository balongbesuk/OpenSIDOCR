<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <?php $this->load->view("$folder_themes/commons/meta.php"); ?>
</head>
<body class="bg-white dark:bg-slate-950 font-sans text-slate-900 dark:text-slate-100 selection:bg-brand-100 dark:selection:bg-brand-900 selection:text-brand-900 dark:selection:text-brand-100 transition-colors duration-300 overflow-x-hidden">
    
    <!-- Navbar (Fixed) -->
    <?php $this->load->view("$folder_themes/commons/header.php"); ?>

    <!-- Main Dynamic Content Wrapper -->
    <div class="min-h-screen flex flex-col">
        
        <?php 
        // Logic: Tampilkan Slider & Profil Hanya di Beranda (Bukan Search)
        if ((empty($_GET['cari'])) && ((count($slide_galeri)>0 || count($artikel)>0))): ?>
            
            <!-- Hero Section -->
            <main id="hero" class="w-full">
                <?php $this->load->view("$folder_themes/partials/slider.php"); ?>
            </main>
            
            <!-- Statistical Section -->
            <section id="profil-transparansi" class="dark:bg-slate-950">
                <?php $this->load->view("$folder_themes/commons/profildesa.php"); ?>
            </section>

        <?php else: ?>
            <!-- Spacer for Sub-pages/Search -->
            <div class="h-24 md:h-32"></div>
        <?php endif; ?>

        <!-- Content & News Section -->
        <main class="flex-1">
            <div class="w-full">
                <?php $this->load->view("$folder_themes/partials/content.php"); ?>
                
                <?php 
                // Opsional: Laman Pelayanan
                if (file_exists(FCPATH . $folder_themes . "/commons/pelayanan.php")) {
                    $this->load->view("$folder_themes/commons/pelayanan.php"); 
                }
                ?>
            </div>
        </main>

        <!-- Footer -->
        <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>

    </div>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-8 right-8 w-14 h-14 bg-brand-600 text-white rounded-2xl shadow-2xl shadow-brand-600/40 flex items-center justify-center opacity-0 invisible translate-y-10 transition-all duration-500 hover:bg-brand-900 z-50" aria-label="Kembali ke Atas">
        <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
    </button>

    <script src="<?= base_url($folder_themes . '/assets/js/app.js') ?>"></script>

    <!-- AOS (Animate On Scroll) Logic -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</body>
</html>