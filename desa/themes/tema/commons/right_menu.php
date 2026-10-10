<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<aside class="space-y-4">
    <?php
    if($w_cos){
        foreach($w_cos as $widget){
            $judul_widget = str_replace('Desa', ucwords($this->setting->sebutan_desa), strip_tags($widget['judul']));
            $data_widget = [
                'judul_widget' => $judul_widget
            ];

            if($widget["jenis_widget"] == 1){
                $this->load->view("{$folder_themes}/widgets/{$widget['isi']}", $data_widget);

            } elseif($widget["jenis_widget"] == 2){
                // Load core widget
                $this->load->view("../../{$widget['isi']}", $data_widget);

            } else {
                // Ad-hoc widget content (Universal Premium Container)
                echo "
                <div class='mb-10 group/widget'>
                    <div class='bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-slate-950/50 overflow-hidden transition-all duration-500 hover:shadow-2xl relative'>
                        <!-- Header -->
                        <div class='p-8 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/30 dark:bg-slate-800/20'>
                            <h3 class='premium-h1 text-[11px] uppercase tracking-[0.2em] flex items-center gap-4'>
                                <div class='w-1.5 h-8 bg-brand-600 rounded-full'></div>
                                ". $judul_widget ."
                            </h3>
                        </div>

                        <!-- Body -->
                        <div class='p-8 relative z-10 text-sm text-slate-600 dark:text-slate-400 leading-relaxed widget-ad-hoc'>
                            ". html_entity_decode($widget['isi']) ."
                        </div>

                        <!-- Decor -->
                        <div class='absolute -right-8 -bottom-8 w-40 h-40 bg-slate-50 dark:bg-slate-800/30 rounded-full blur-3xl pointer-events-none opacity-50'></div>
                    </div>
                </div>";
            }
        }
    }
    ?>
</aside>

<style>
    .widget-ad-hoc img { border-radius: 1rem; margin: 1rem 0; width: 100%; height: auto; }
    .widget-ad-hoc ul { list-style: disc; padding-left: 1.5rem; margin-top: 1rem; }
    .widget-ad-hoc a { color: #2563eb; font-weight: 600; }
</style>
