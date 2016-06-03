<?php 
	session_start();
  error_reporting(E_ALL);
  ini_set('display_errors','Off');
  include_once "carlsberg_function.php";
        //if ($_SERVER['REQUEST_HOST'] == 'vostok.spb.ru')

        if (strpos ($_SERVER['REQUEST_URI'],'/catalog')===0 || $_SERVER['REQUEST_URI'] == '/specodezhda.php')
        {

$studio_catalog_common = array(
  '/catalog4/models150/kurtka_spec_avangard_101008161.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kurtka_specavangard_101008161.php',
  '/catalog4/models150/bruki_specavangard_101008261.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/bruki_specavangard_101008261.php',
  '/catalog4/models150/jilet_specavangard_101008361.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/jilet_specavangard_101008361.php',
  '/catalog4/models150/polukombinezon_specavangard_101008461.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/polukombinezon_specavangard_101008461.php',
  '/catalog4/models150/kurtka_spec_avangard_101008102.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kurtka_specavangard_101008102.php',
  '/catalog4/models150/bruki_spec_avangard_101019402.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/bruki_specavangard_101019402.php',
  '/catalog4/models150/polukombinezon_spec_avangard_101019502.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/polukombinezon_specavangard_101019502.php',
  '/catalog4/models150/jilet_spec_avangard_101019602.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/jilet_specavangard_101019602.php',
  '/catalog4/models150/kurtka_spec_avangard_101008101.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kurtka_specavangard_101008101.php',
  '/catalog4/models150/bruki_spec_avangard_101019401.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/bruki_specavangard_101019401.php',
  '/catalog4/models150/polukombinezon_spec_avangard_101019501.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/polukombinezon_specavangard_101019501.php',
  '/catalog4/models150/jilet_spec_avangard_101019601.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/jilet_specavangard_101019601.php',
  '/catalog4/models150/kurtka_spec_101021202.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kurtka_spec_101021202.php',
  '/catalog4/models150/kurtka_spec_101021201.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kurtka_spec_101021201.php',
  '/catalog4/models150/kostum_specantistat_101010157.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_specantistat_101010157.php',
  '/catalog4/models10099/shorty_cerva_emerton_101017401.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/shorty_CERVA_emerton_101017401.php',
  '/catalog4/models10099/bruki_cerva_olza_101010601.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/bruki_CERVA_olza_101010601.php',
  '/catalog4/models10099/jilet_cerva_olza_101010401.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/jilet_CERVA_olza_101010401.php',
  '/catalog4/models10099/bruki_cerva_stanmore_101007036.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/bruki_CERVA_stanmore_101007036.php',
  '/catalog4/models10099/jilet_cerva_stanmore_101018001.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/jilet_CERVA_stanmore_101018001.php',
  '/catalog4/models10099/shorty_cerva_stanmore_101017501.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/shorty_CERVA_stanmore_101017501.php',
  '/catalog4/models10099/kurtka_cerva_ukari_101010801.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kurtka_CERVA_ukari_101010801.php',
  '/catalog4/models10099/bruki_cerva_ukari_101011001.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/bruki_CERVA_ukari_101011001.php',
  '/catalog4/models17/kostum_novator_101003904.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_novator_101003904.php',
  '/catalog4/models17/kostum_motor_101003601.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_motor_101003601.php',
  '/catalog4/models17/kostum_novator_101003905.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_novator_101003905.php',
  '/catalog4/models17/kostum_motor_101003633.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_motor_101003633.php',
  '/catalog4/models17/kostum_ladoga_101002413.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_ladoga_101002413.php',
  '/catalog4/models17/kostum_brigada_101002827.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_brigada_101002827.php',
  '/catalog4/models17/kostum_injener_101006526.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_injener_101006526.php',
  '/catalog4/models17/kostum_masterica_101003013.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_masterica_101003013.php',
  '/catalog4/models17/kostum_vityaz_so_101013601.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_vityaz_so_101013601.php',
  '/catalog4/models17/kostum_klab_101002923.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_klab_101002923.php',
  '/catalog4/models17/kostum_klab_101002916.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_klab_101002916.php',
  '/catalog4/models17/bruki_klab_101005916.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/bruki_klab_101005916.php',
  '/catalog4/models17/kostum_master_101000823.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_master_101000823.php',
  '/catalog4/models17/kostum_vysota_101003150.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_vysota_101003150.php',
  '/catalog4/models17/kostum_vysota1_101008836.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_vysota1_101008836.php',
  '/catalog4/models17/kostum_saturnn_101011201.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_saturnn_101011201.php',
  '/catalog4/models17/kostum_vesnan_101011301.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_vesnan_101011301.php',
  '/catalog4/models17/kostum_vesnan_101011302.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_vesnan_101011302.php',
  '/catalog4/models17/kostum_baltika_101001053.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_baltika_101001053.php',
  '/catalog4/models17/kostum_baltika1_101009553.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_baltika1_101009553.php',
  '/catalog4/models17/kostum_baltika1_101009503.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_baltika1_101009503.php',
  '/catalog4/models17/kostum_trudn_101011401.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_trudn_101011401.php',
  '/catalog4/models17/kostum_trudn_101011402.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_trudn_101011402.php',
  '/catalog4/models17/kostum_mehanik_101001253.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_mehanik_101001253.php',
  '/catalog4/models17/kostum_mehanik_101001203.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_mehanik_101001203.php',
  '/catalog4/models17/polukombinezon_start_101003753.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/polukombinezon_start_101003753.php',
  '/catalog4/models17/polukombinezon_start_101003703.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/polukombinezon_start_101003703.php',
  '/catalog4/models17/halat_tehnik_101000723.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/halat_tehnik_101000723.php',
  '/catalog4/models17/halat_tehnik_101000753.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/halat_tehnik_101000753.php',
  '/catalog4/models17/halat_hozyayka_101000601.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/halat_hozyayka_101000601.php',
  '/catalog4/models17/halat_hozyayka_101000653.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/halat_hozyayka_101000653.php',
  '/catalog4/models17/halat_hozyayka_101000623.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/halat_hozyayka_101000623.php',
  '/catalog4/models17/jilet_instrumental_101005153.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/jilet_instrumental_101005153.php',
  '/catalog4/models17/kombinezon_orion_101000153.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kombinezon_orion_101000153.php',
  '/catalog4/models17/kombinezon_orion_101000103.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kombinezon_orion_101000103.php',
  '/catalog4/models17/kostum_baykal1_101008701.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_baykal1_101008701.php',
  '/catalog4/models17/kostum_baykal1_101008703.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_baykal1_101008703.php',
  '/catalog4/models17/kostum_kombinatn_101001310.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kostum_kombinatn_101001310.php',
  '/catalog4/models17/bruki_kombinat_101006410.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/bruki_kombinat_101006410.php',
  '/catalog4/models21/komplekt_pekarya_101001414.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/komplekt_pekarya_101001414.php',
  '/catalog4/models17/halat_laboratoriya_101006010.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/halat_laboratoriya_101006010.php',
  '/catalog4/models17/halat_laboratoriya_101006014.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/halat_laboratoriya_101006014.php',
  '/catalog4/models17/halat_laborant_101002010.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/halat_laborant_101002010.php',
  '/catalog4/models17/halat_laborant_101002014.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/halat_laborant_101002014.php',
  '/catalog4/models17/halat_laboratoriyad_101002110.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/halat_laboratoriyad_101002110.php',
  '/catalog4/models17/halat_laborantd_101006810.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/halat_laborantd_101006810.php',
  '/catalog4/models10099/futbolka_cerva_stanmore_101004836.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/futbolka_CERVA_stanmore_101004836.php',
  '/catalog4/models10099/futbolka_cerva_emerton_101004933.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/futbolka_CERVA_emerton_101004933.php',
  '/catalog4/models10099/bruki_cerva_emerton_101004345.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/bruki_CERVA_emerton_101004345.php',
  '/catalog4/models10099/jilet_cerva_emerton_101007245.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/jilet_CERVA_emerton_101007245.php',
  '/catalog4/models10099/kurtka_cerva_narellan_101004461.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kurtka_CERVA_narellan_101004461.php',
  '/catalog4/models10099/kurtka_cerva_stanmore_101004536.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kurtka_CERVA_stanmore_101004536.php',
  '/catalog4/models10099/kurtka_cerva_emerton_101006745.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/kurtka_CERVA_emerton_101006745.php',
  '/catalog4/models10099/polukombinezon_cerva_emerton_101004745.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/specodejda_letnyaya/polukombinezon_CERVA_emerton_101004745.php',
  '/catalog4/models17/komplekt_telohranitel_101002711.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/kostumy_protivoencefalitnye/komplekt_telohranitel_101002711.php',
  '/catalog10087/models10088/kostum_eger_101004108.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/kostumy_protivoencefalitnye/kostum_eger_101004108.php',
  '/catalog4/models15/kurtkavetrovka_shtormovka_101009456.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/kostumy_protivoencefalitnye/kurtkavetrovka_shtormovka_101009456.php',
  '/catalog4/models10099/kurtka_cerva_djeneli_101004002.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/odejda_iz_flisa/kurtka_CERVA_djeneli_101004002.php',
  '/catalog4/models10099/kurtka_cerva_djeneli_101004001.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/odejda_iz_flisa/kurtka_CERVA_djeneli_101004001.php',
  '/catalog4/models10099/kurtka_cerva_djeneli_101004010.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/odejda_iz_flisa/kurtka_CERVA_djeneli_101004010.php',
  '/catalog4/models12/kurtka_alfa_101006911.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/odejda_iz_flisa/kurtka_alfa_101006911.php',
  '/catalog10087/models10088/kurtka_polar_101000323.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/odejda_iz_flisa/kurtka_polar_101000323.php',
  '/catalog4/models17/jilet_raft_101005807.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/odejda_iz_flisa/jilet_raft_101005807.php',
  '/catalog/models1088/kurtka_flis_101006323.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/odejda_iz_flisa/kurtka_flis_101006323.php',
  '/catalog4/models10099/bruki_cerva_olza_101010603.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/odejda_iz_flisa/bruki_CERVA_olza_101010603.php',
  '/catalog4/models10099/kurtka_cerva_olza_101010703.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/odejda_iz_flisa/kurtka_CERVA_olza_101010703.php',
  '/catalog4/models17/triko_cerva_lion_101014601.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/bele_natelnoe_futbolki_rubashki/triko_CERVA_lion_101014601.php',
  '/catalog4/models17/triko_cerva_lion_101014602.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/bele_natelnoe_futbolki_rubashki/triko_CERVA_lion_101014602.php',
  '/catalog4/models10099/futbolka_cerva_lion_s_dlinnym_rukavom_101014501.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/bele_natelnoe_futbolki_rubashki/futbolka_CERVA_lion_s_dlinnym_rukavom_101014501.php',
  '/catalog4/models10099/futbolka_cerva_lion_s_dlinnym_rukavom_101014502.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/bele_natelnoe_futbolki_rubashki/futbolka_CERVA_lion_s_dlinnym_rukavom_101014502.php',
  '/catalog10087/models10088/bele_atribut_101007814.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/bele_natelnoe_futbolki_rubashki/bele_atribut_101007814.php',
  '/catalog10087/models10088/bele_normativ_101007684.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/bele_natelnoe_futbolki_rubashki/bele_normativ_101007684.php',
  '/catalog10087/models10088/bele_forma_101008914.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/bele_natelnoe_futbolki_rubashki/bele_forma_101008914.php',
  '/catalog4/models17/telnyashka_bocman_101009139.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/bele_natelnoe_futbolki_rubashki/telnyashka_bocman_101009139.php',
  '/catalog4/models17/telnyashka_rechnik_101009039.php'=>'/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/bele_natelnoe_futbolki_rubashki/telnyashka_rechnik_101009039.php',
  '/catalog4/models150/kepka_spec_102001907.php'=>'/specodejda/golovnye_ubory/kepka_spec_102001907.php',
  '/catalog4/models150/kepka_spec_102001901.php'=>'/specodejda/golovnye_ubory/kepka_spec_102001901.php',
  '/catalog4/models17/kepkajokeyka_souz_102000453.php'=>'/specodejda/golovnye_ubory/kepkajokeyka_souz_102000453.php',
  '/catalog4/models17/kepkajokeyka_souz_102000403.php'=>'/specodejda/golovnye_ubory/kepkajokeyka_souz_102000403.php',
  '/catalog4/models17/kepkajokeyka_souz_102000401.php'=>'/specodejda/golovnye_ubory/kepkajokeyka_souz_102000401.php',
  '/catalog4/models17/kepkajokeyka_souz_102002801.php'=>'/specodejda/golovnye_ubory/kepkajokeyka_souz2_102002801.php',
  '/catalog4/models17/kepkajokeyka_souz_102000402.php'=>'/specodejda/golovnye_ubory/kepkajokeyka_souz_102000402.php',
  '/catalog4/models107/kepkajokeyka_straj_102001810.php'=>'/specodejda/golovnye_ubory/kepkajokeyka_straj_102001810.php',
  '/catalog6/models32/podshlemnik_stroitel_102002210.php'=>'/specodejda/golovnye_ubory/podshlemnik_stroitel_102002210.php',
  '/catalog6/models32/podshlemnik_oplot_102002310.php'=>'/specodejda/golovnye_ubory/podshlemnik_oplot_102002310.php',
  '/catalog4/models12/shapka_ushanka_102002410.php'=>'/specodejda/golovnye_ubory/shapka_ushanka_102002410.php',
  '/catalog4/models12/shapka_cigeyka_102000310.php'=>'/specodejda/golovnye_ubory/shapka_cigeyka_102000310.php',
  '/catalog4/models12/shapka_vershina_102001210.php'=>'/specodejda/golovnye_ubory/shapka_vershina_102001210.php',
  '/catalog4/models12/shapka_skeyter3_102001323.php'=>'/specodejda/golovnye_ubory/shapka_skeyter3_102001323.php',
  '/catalog4/models12/shapka_skeyter3_102001303.php'=>'/specodejda/golovnye_ubory/shapka_skeyter3_102001303.php',
  '/catalog4/models12/shapka_skeyter3_102001310.php'=>'/specodejda/golovnye_ubory/shapka_skeyter3_102001310.php',
  '/catalog4/models12/shapka_omega_102002701.php'=>'/specodejda/golovnye_ubory/shapka_omega_102002701.php',
  '/catalog4/models12/shapka_omega_102002702.php'=>'/specodejda/golovnye_ubory/shapka_omega_102002702.php',
  '/catalog4/models12/sharf_shkiper_102002110.php'=>'/specodejda/golovnye_ubory/sharf_shkiper_102002110.php',
  '/catalog10087/models10088/panama_protivomoskitnaya_102001611.php'=>'/specodejda/golovnye_ubory/panama_protivomoskitnaya_102001611.php',
  '/catalog4/models12/kostum_monblanultra_103006547.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_monblanultra_103006547.php',
  '/catalog4/models12/kostum_monblankamo_103006401.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_monblankamo_103006401.php',
  '/catalog4/models12/kostum_nordn_103009207.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_nordn_103009207.php',
  '/catalog4/models12/kurtka_nordn_103009701.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_nordn_103009701.php',
  '/catalog4/models150/kostum_spec_103003464.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_spec_103003464.php',
  '/catalog4/models150/kostum_ledi_spec_103003564.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_ledi_spec_103003564.php',
  '/catalog4/models150/kostum_spec_103003440.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_spec_103003440.php',
  '/catalog4/models150/kostum_ledi_spec_103003540.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_ledi_spec_103003540.php',
  '/catalog4/models150/kurtka_ledi_spec_103009601.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_ledi_spec_103009601.php',
  '/catalog4/models150/kostum_ledi_spec1_103010701.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_ledi_spec1_103010701.php',
  '/catalog4/models10099/kurtka_cerva_emerton_103005845.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_CERVA_emerton_103005845.php',
  '/catalog4/models10099/kurtka_cerva_ukari_103006701.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_CERVA_ukari_103006701.php',
  '/catalog4/models12/kostum_drayv_103003005.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_drayv_103003005.php',
  '/catalog4/models12/kurtka_drayv_103007001.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_drayv_103007001.php',
  '/catalog4/models12/kostum_ledi_drayv_103008701.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_ledi_drayv_103008701.php',
  '/catalog4/models12/kostum_drayv_103003004.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_drayv_103003004.php',
  '/catalog4/models12/kurtka_drayv_103007002.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_drayv_103007002.php',
  '/catalog4/models12/kurtka_alyaska_103000710.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_alyaska_103000710.php',
  '/catalog4/models12/kurtka_alyaska_103000716.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_alyaska_103000716.php',
  '/catalog4/models12/kurtka_alyaska_luks_103002710.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_alyaska_luks_103002710.php',
  '/catalog4/models12/kurtka_russkaya_alyaska_103000201.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_russkaya_alyaska_103000201.php',
  '/catalog4/models12/kurtka_russkaya_alyaska_103000202.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_russkaya_alyaska_103000202.php',
  '/catalog4/models12/kurtka_korona_103005256.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_korona_103005256.php',
  '/catalog4/models12/kurtka_vinterstayl_103002010.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_vinterstayl_103002010.php',
  '/catalog4/models12/kurtka_vinterstayl_103002007.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_vinterstayl_103002007.php',
  '/catalog4/models12/kurtka_bumer_103001910.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_bumer_103001910.php',
  '/catalog4/models12/kurtka_reynblokn_103006901.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_reynblokn_103006901.php',
  '/catalog4/models12/kurtka_reynblokn_103006902.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_reynblokn_103006902.php',
  '/catalog4/models12/kurtka_nevada_103003822.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_nevada_103003822.php',
  '/catalog4/models12/kurtka_nevada_103003844.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_nevada_103003844.php',
  '/catalog4/models12/kurtka_fristayl_103001844.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_fristayl_103001844.php',
  '/catalog4/models12/kurtka_fristayl_103001850.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_fristayl_103001850.php',
  '/catalog4/models12/kurtka_doker_103004553.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_doker_103004553.php',
  '/catalog4/models12/kurtka_shturman_103004223.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_shturman_103004223.php',
  '/catalog4/models12/kurtka_vostok_103000419.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_vostok_103000419.php',
  '/catalog4/models12/kostum_vuga_103000323.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_vuga_103000323.php',
  '/catalog4/models12/kostum_iney_v791_103002401.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_iney_v791_103002401.php',
  '/catalog4/models12/kostum_iney_v791_103002402.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_iney_v791_103002402.php',
  '/catalog4/models12/kombinezon_format_103001253.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kombinezon_format_103001253.php',
  '/catalog4/models12/polukombinezon_praktik_103004123.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/polukombinezon_praktik_103004123.php',
  '/catalog4/models12/bruki_flay_103002923.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/bruki_flay_103002923.php',
  '/catalog4/models12/bruki_flay_103002910.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/bruki_flay_103002910.php',
  '/catalog4/models12/kostum_metelicap_103001316.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kostum_metelicap_103001316.php',
  '/catalog4/models12/kurtka_zimovka_so_103010501.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_zimovka_so_103010501.php',
  '/catalog4/models12/kurtka_zimovka_so_103010502.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_zimovka_so_103010502.php',
  '/catalog4/models12/bruki_zimovka_103003303.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/bruki_zimovka_103003303.php',
  '/catalog4/models12/bruki_zimovka_103003316.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/bruki_zimovka_103003316.php',
  '/catalog4/models12/kurtka_telogreykap_103006016.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/kurtka_telogreykap_103006016.php',
  '/catalog4/models12/bruki_karerp_103001016.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/bruki_karerp_103001016.php',
  '/catalog4/models12/jilet_teplon_103004710.php'=>'/specodejda/zashhita_ot_ponijennyh_temperatur/jilet_teplon_103004710.php',
  '/catalog4/models132/kostum_dorojnik_104001101.php'=>'/specodejda/signalnaya_odejda/kostum_dorojnik_104001101.php',
  '/catalog4/models132/kostum_asfalt_master_104000676.php'=>'/specodejda/signalnaya_odejda/kostum_asfalt_master_104000676.php',
  '/catalog4/models132/kostum_dorojnik_104000765.php'=>'/specodejda/signalnaya_odejda/kostum_dorojnik_104000765.php',
  '/catalog4/models132/kostum_brayt_104000574.php'=>'/specodejda/signalnaya_odejda/kostum_brayt_104000574.php',
  '/catalog4/models132/plashh_signal_104001574.php'=>'/specodejda/signalnaya_odejda/plashh_signal_104001574.php',
  '/catalog4/models132/jilet_doroga_104001201.php'=>'/specodejda/signalnaya_odejda/jilet_doroga_104001201.php',
  '/catalog4/models132/jilet_gabarit_104000174.php'=>'/specodejda/signalnaya_odejda/jilet_gabarit_104000174.php',
  '/catalog4/models132/jilet_gabarit_104000165.php'=>'/specodejda/signalnaya_odejda/jilet_gabarit_104000165.php',
  '/catalog4/models132/jilet_gard_104000265.php'=>'/specodejda/signalnaya_odejda/jilet_gard_104000265.php',
  '/catalog4/models132/jiletnakidka_mayak_104000374.php'=>'/specodejda/signalnaya_odejda/jiletnakidka_mayak_104000374.php',
  '/catalog4/models132/jiletnakidka_mayak_104000365.php'=>'/specodejda/signalnaya_odejda/jiletnakidka_mayak_104000365.php',
  '/catalog4/models132/jilet_aeron_104000865.php'=>'/specodejda/signalnaya_odejda/jilet_aeron_104000865.php',
  '/catalog4/models132/jilet_aeron_104000874.php'=>'/specodejda/signalnaya_odejda/jilet_aeron_104000874.php',
  '/catalog4/models132/jilet_rjd_104001765.php'=>'/specodejda/signalnaya_odejda/jilet_rjd_104001765.php',
  '/catalog4/models14/kostum_zevs_105001979.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/dlya_svarshhikov/kostum_zevs_105001979.php',
  '/catalog4/models14/kostum_zevs_plus_105003879.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/dlya_svarshhikov/kostum_zevs_plus_105003879.php',
  '/catalog6/models32/podshlemnik_zevs_105003110.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/dlya_svarshhikov/podshlemnik_zevs_105003110.php',
  '/catalog4/models14/kostum_gerkules_105001601.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/dlya_svarshhikov/kostum_gerkules_105001601.php',
  '/catalog4/models14/kostum_bulat_105003956.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/dlya_svarshhikov/kostum_bulat_105003956.php',
  '/catalog4/models14/kostum_bazalt_105004210.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/dlya_svarshhikov/kostum_bazalt_105004210.php',
  '/catalog4/models14/kostum_bastion_105004046.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/dlya_svarshhikov/kostum_bastion_105004046.php',
  '/catalog4/models14/kostum_bastion_plus_105002310.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/dlya_svarshhikov/kostum_bastion_plus_105002310.php',
  '/catalog4/models14/kostum_metallurg_105001507.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/dlya_metallurgov/kostum_metallurg_105001507.php',
  '/catalog4/models14/shlyapa_metallurg_102002507.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/dlya_metallurgov/shlyapa_metallurg_8mm_gsh_102002507.php',
  '/catalog4/models14/kostum_stalevar_105004110.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/dlya_metallurgov/kostum_stalevar_105004110.php',
  '/catalog4/models14/kostum_moleskin_105002410.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/dlya_metallurgov/kostum_moleskin_105002410.php',
  '/catalog4/models14/komplekt_bop_dlya_nach__sostava_105000480.php'=>'/specodejda/zashhita_ot_povyshennyh_temperatur/boevaya_odejda_pojarnyh/komplekt_bop_dlya_nach__sostava_105000480.php',
  '/catalog4/models15/kostum_barguzin_106000805.php'=>'/specodejda/zashhita_ot_vlagi/kostum_barguzin_106000805.php',
  '/catalog4/models15/kostum_barguzin_106000803.php'=>'/specodejda/zashhita_ot_vlagi/kostum_barguzin_106000803.php',
  '/catalog4/models15/plashh_barguzin_106001805.php'=>'/specodejda/zashhita_ot_vlagi/plashh_barguzin_106001805.php',
  '/catalog4/models15/plashh_barguzin_106001803.php'=>'/specodejda/zashhita_ot_vlagi/plashh_barguzin_106001803.php',
  '/catalog4/models15/kostum_forest_106000605.php'=>'/specodejda/zashhita_ot_vlagi/kostum_forest_106000605.php',
  '/catalog4/models15/kostum_forest_106000616.php'=>'/specodejda/zashhita_ot_vlagi/kostum_forest_106000616.php',
  '/catalog4/models15/plashh_forest_106002016.php'=>'/specodejda/zashhita_ot_vlagi/plashh_forest_106002016.php',
  '/catalog4/models15/plashh_forest_106002003.php'=>'/specodejda/zashhita_ot_vlagi/plashh_forest_106002003.php',
  '/catalog4/models15/plashh_forest_106002005.php'=>'/specodejda/zashhita_ot_vlagi/plashh_forest_106002005.php',
  '/catalog4/models15/kostum_grinvud_106001154.php'=>'/specodejda/zashhita_ot_vlagi/kostum_grinvud_106001154.php',
  '/catalog4/models15/kostum_grinvud_106001111.php'=>'/specodejda/zashhita_ot_vlagi/kostum_grinvud_106001111.php',
  '/catalog4/models15/plashh_grinvud_106001254.php'=>'/specodejda/zashhita_ot_vlagi/plashh_grinvud_106001254.php',
  '/catalog4/models15/plashh_grinvud_106001211.php'=>'/specodejda/zashhita_ot_vlagi/plashh_grinvud_106001211.php',
  '/catalog4/models15/kostum_rokonbuksa_106000225.php'=>'/specodejda/zashhita_ot_vlagi/kostum_rokonbuksa_106000225.php',
  '/catalog4/models15/komplekt_ryboobrabotchik_106001584.php'=>'/specodejda/zashhita_ot_vlagi/komplekt_ryboobrabotchik_106001584.php',
  '/catalog4/models15/kostum_shahter_106000303.php'=>'/specodejda/zashhita_ot_vlagi/kostum_shahter_106000303.php',
  '/catalog4/models15/komplekt_l1_bez_voennoy_priemki_106002801.php'=>'/specodejda/zashhita_ot_vlagi/komplekt_l1_bez_voennoy_priemki_106002801.php',
  '/catalog4/models15/polukombinezon_s_sapogami_liman_106001703.php'=>'/specodejda/zashhita_ot_vlagi/polukombinezon_s_sapogami_liman_106001703.php',
  '/catalog4/models15/plashh_vlagostoykiy_redut_106001310.php'=>'/specodejda/zashhita_ot_vlagi/plashh_vlagostoykiy_redut_106001310.php',
  '/catalog4/models15/fartuk_rubej_106000410.php'=>'/specodejda/zashhita_ot_vlagi/fartuk_rubej_106000410.php',
  '/catalog4/models15/kurtkavetrovka_musson_106000123.php'=>'/specodejda/zashhita_ot_vlagi/kurtkavetrovka_musson_106000123.php',
  '/catalog4/models10085/kostum_magnoliya_107002068.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/kostum_magnoliya_107002068.php',
  '/catalog4/models10085/kostum_magnoliya_107002001.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/kostum_magnoliya_107002001.php',
  '/catalog4/models10085/halat_tonus_107001801.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/halat_tonus_107001801.php',
  '/catalog4/models10085/halat_ledi_tonus_107001901.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/halat_ledi_tonus_107001901.php',
  '/catalog4/models10085/halat_marta_107001614.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/halat_marta_107001614.php',
  '/catalog4/models10085/halat_katrin_107001714.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/halat_katrin_107001714.php',
  '/catalog4/models10085/halat_arnika_107000214.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/halat_arnika_107000214.php',
  '/catalog4/models10085/kostum_melissa_107000329.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/kostum_melissa_107000329.php',
  '/catalog4/models10085/kostum_anis_107001329.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/kostum_anis_107001329.php',
  '/catalog4/models10085/komplekt_doktor_107001218.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/komplekt_doktor_107001218.php',
  '/catalog4/models10085/komplekt_doktor_107001202.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/komplekt_doktor_107001202.php',
  '/catalog4/models10085/halat_medikal_107000414.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/halat_medikal_107000414.php',
  '/catalog4/models10085/halat_ledi_medikal_107000514.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/halat_ledi_medikal_107000514.php',
  '/catalog4/models21/halat_viktoriya_107001501.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/halat_viktoriya_107001501.php',
  '/catalog4/models21/halat_viktoriya_107001502.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/halat_viktoriya_107001502.php',
  '/catalog4/models21/halat_viktoriya_107001505.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/halat_viktoriya_107001505.php',
  '/catalog4/models21/halat_alina_107000602.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/halat_alina_107000602.php',
  '/catalog4/models21/bluza_snejana_107000914.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/bluza_snejana_107000914.php',
  '/catalog4/models21/komplekt_karina_107001002.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/komplekt_karina_107001002.php',
  '/catalog4/models21/komplekt_kameliya_107001460.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/komplekt_kameliya_107001460.php',
  '/catalog4/models21/komplekt_kameliya_107001471.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/komplekt_kameliya_107001471.php',
  '/catalog4/models21/komplekt_feya_107000801.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/komplekt_feya_107000801.php',
  '/catalog4/models21/komplekt_feya_107000816.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/komplekt_feya_107000816.php',
  '/catalog4/models21/komplekt_nadejda_prodavca_107002201.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/komplekt_nadejda_dlya_prodavca_107002201.php',
  '/catalog4/models21/komplekt_nadejda_prodavca_107002202.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/komplekt_nadejda_dlya_prodavca_107002202.php',
  '/catalog4/models21/komplekt_briz_107001101.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/komplekt_briz_107001101.php',
  '/catalog4/models21/komplekt_briz_107001105.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/komplekt_briz_107001105.php',
  '/catalog4/models21/komplekt_briz_107001106.php'=>'/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_predpriyatiy_torgovli_obshhestvennogo_pitaniy_bytovogo_obslujivaniya/komplekt_briz_107001106.php',
  '/catalog4/models12/komplekt_les_108005701.php'=>'/specodejda/specodejda_dlya_lesorubov/komplekt_les_108005701.php',
  '/catalog4/models107/kostum_straj_109000110.php'=>'/specodejda/odejda_v_stile_militari/dlya_ohrannyh_struktur/kostum_straj_109000110.php',
  '/catalog4/models107/kostum_straj_109000183.php'=>'/specodejda/odejda_v_stile_militari/dlya_ohrannyh_struktur/kostum_straj_109000183.php',
  '/catalog4/models17/sorochka_straj_109000502.php'=>'/specodejda/odejda_v_stile_militari/dlya_ohrannyh_struktur/sorochka_straj_109000502.php',
  '/catalog4/models107/galstuk_straj_109001510.php'=>'/specodejda/odejda_v_stile_militari/dlya_ohrannyh_struktur/galstuk_straj_109001510.php',
  '/catalog4/models107/kurtka_zashhita_109000610.php'=>'/specodejda/odejda_v_stile_militari/dlya_ohrannyh_struktur/kurtka_zashhita_109000610.php',
  '/catalog4/models107/kurtka_sekuritin_109006302.php'=>'/specodejda/odejda_v_stile_militari/dlya_ohrannyh_struktur/kurtka_sekuritin_109006302.php',
  '/catalog4/models107/kostum_sekuritin_109006501.php'=>'/specodejda/odejda_v_stile_militari/dlya_ohrannyh_struktur/kostum_sekuritin_109006501.php',
  '/catalog4/models107/kostum_sekuritin_109006502.php'=>'/specodejda/odejda_v_stile_militari/dlya_ohrannyh_struktur/kostum_sekuritin_109006502.php',
  '/catalog4/models107/kostum_kapral_109000482.php'=>'/specodejda/odejda_v_stile_militari/dlya_rybalki_ohoty_turizma_aktivnogo_otdyha/kostum_kapral_109000482.php',
  '/catalog4/models107/kepka_kapral_109001682.php'=>'/specodejda/odejda_v_stile_militari/dlya_rybalki_ohoty_turizma_aktivnogo_otdyha/kepka_kapral_109001682.php',
  '/catalog4/models107/kostum_aviator_109000982.php'=>'/specodejda/odejda_v_stile_militari/dlya_rybalki_ohoty_turizma_aktivnogo_otdyha/kostum_aviator_109000982.php',
  '/catalog4/models107/kostum_koyot_109003108.php'=>'/specodejda/odejda_v_stile_militari/dlya_rybalki_ohoty_turizma_aktivnogo_otdyha/kostum_koyot_109003108.php',
  '/catalog4/models12/kostum_koyot_109003101.php'=>'/specodejda/odejda_v_stile_militari/dlya_rybalki_ohoty_turizma_aktivnogo_otdyha/kostum_koyot_109003101.php',
  '/catalog4/models107/kostum_delta_109005911.php'=>'/specodejda/odejda_v_stile_militari/dlya_rybalki_ohoty_turizma_aktivnogo_otdyha/kostum_delta_109005911.php',
  '/catalog4/models12/kurtka_desant_109005011.php'=>'/specodejda/odejda_v_stile_militari/dlya_rybalki_ohoty_turizma_aktivnogo_otdyha/kurtka_desant_109005011.php',
  '/catalog4/models93/kostum_barrel_plus_110000523.php'=>'/specodejda/zashhita_ot_nefti_i_nefteproduktov/kostum_barrel_plus_110000523.php',
  '/catalog4/models93/kostum_neftyanik_110000656.php'=>'/specodejda/zashhita_ot_nefti_i_nefteproduktov/kostum_neftyanik_110000656.php',
  '/catalog4/models93/komplekt_neftyanik_plus_110000710.php'=>'/specodejda/zashhita_ot_nefti_i_nefteproduktov/komplekt_neftyanik_plus_110000710.php',
  '/catalog4/models108/kostum_himogard_111000535.php'=>'/specodejda/zashhita_ot_kislot_i_shhelochey/kostum_himogard_111000535.php',
  '/catalog4/models108/halat_ledi_kemis1_111001201.php'=>'/specodejda/zashhita_ot_kislot_i_shhelochey/halat_ledi_kemis1_111001201.php',
  '/catalog4/models108/kostum_kemi_stayl_111000336.php'=>'/specodejda/zashhita_ot_kislot_i_shhelochey/kostum_kemi_stayl_111000336.php',
  '/catalog4/models108/kostum_tantal_111000107.php'=>'/specodejda/zashhita_ot_kislot_i_shhelochey/kostum_tantal_111000107.php',
  '/catalog4/models17/kombinezon_dupont_tayvek_snf5_112001314.php'=>'/specodejda/specodejda_ogranichennogo_sroka_deystviya/kombinezon_DuPont_tayvek_snF5_112001314.php',
  '/catalog4/models17/kombinezon_dupont_taykem_s_cha5_112000305.php'=>'/specodejda/specodejda_ogranichennogo_sroka_deystviya/kombinezon_DuPont_taykem_s_CHA5_112000305.php',
  '/catalog4/models17/kombinezon_dupont_taykem_f_cha5_112000407.php'=>'/specodejda/specodejda_ogranichennogo_sroka_deystviya/kombinezon_DuPont_taykem_F_CHA5_112000407.php',
  '/catalog4/models15/fartuk_ansell_pvh_uplotnennyy_45g_112001003.php'=>'/specodejda/specodejda_ogranichennogo_sroka_deystviya/fartuk_ANSELL_pvh_uplotnennyy_45G_112001003.php',
  '/catalog4/models15/fartuk_ansell_pvh_uplotnennyy_45w_112002114.php'=>'/specodejda/specodejda_ogranichennogo_sroka_deystviya/fartuk_ANSELL_pvh_uplotnennyy_45W_112002114.php',
  '/catalog4/models17/kombinezon_kasper_112000101.php'=>'/specodejda/specodejda_ogranichennogo_sroka_deystviya/kombinezon_kasper_112000101.php',
  '/catalog4/models17/kombinezon_kasper_112000114.php'=>'/specodejda/specodejda_ogranichennogo_sroka_deystviya/kombinezon_kasper_112000114.php',
  '/catalog5/models366/sapogi_treyl_super_r_120014201.php'=>'/specobuv/demisezonnaya_specobuv/sapogi/sapogi_treyl_super_r_120014201.php',
  '/catalog5/models133/sapogi_toff_alp_120005101.php'=>'/specobuv/demisezonnaya_specobuv/sapogi/sapogi_toff_alp_120005101.php',
  '/catalog5/models133/sapogi_kirzovye_120000901.php'=>'/specobuv/demisezonnaya_specobuv/sapogi/sapogi_kirzovye_120000901.php',
  '/catalog5/models40/botinki_vysokie_toff_berkutm_120017901.php'=>'/specobuv/demisezonnaya_specobuv/vysokie_botinki/botinki_vysokie_toff_berkutm_120017901.php',
  '/catalog5/models40/botinki_vysokie_toff_omon_m_120018001.php'=>'/specobuv/demisezonnaya_specobuv/vysokie_botinki/botinki_vysokie_toff_omon_m_120018001.php',
  '/catalog5/models40/botinki_vysokie_yaguar_120004301.php'=>'/specobuv/demisezonnaya_specobuv/vysokie_botinki/botinki_vysokie_yaguar_120004301.php',
  '/catalog5/models366/botinki_vysokie_treyl_universal_120013701.php'=>'/specobuv/demisezonnaya_specobuv/vysokie_botinki/botinki_vysokie_treyl_universal_120013701.php',
  '/catalog5/models133/botinki_toff_superstaylm_120004101.php'=>'/specobuv/demisezonnaya_specobuv/botinki/botinki_toff_superstaylm_120004101.php',
  '/catalog5/models366/botinki_treyl_plus_t3__120017601.php'=>'/specobuv/demisezonnaya_specobuv/botinki/botinki_treyl_plus_t3_120017601.php',
  '/catalog5/models10101/botinki_panda_strong_6919_s1_120013101.php'=>'/specobuv/demisezonnaya_specobuv/botinki/botinki_PANDA_strong_6919_S1_120013101.php',
  '/catalog5/models27/botinki_toff_ledi_kraft_120004402.php'=>'/specobuv/demisezonnaya_specobuv/botinki/botinki_toff_ledi_kraft_120004402.php',
  '/catalog5/models366/botinki_treyl_iks_120017401.php'=>'/specobuv/demisezonnaya_specobuv/botinki/botinki_treyl_iks_120017401.php',
  '/catalog5/models36/botinki_rang_s1_120005901.php'=>'/specobuv/demisezonnaya_specobuv/botinki/botinki_rang_S1_120005901.php',
  '/catalog5/models27/botinki_toff_kraftm_120004501.php'=>'/specobuv/demisezonnaya_specobuv/botinki/botinki_toff_kraftm_120004501.php',
  '/catalog5/models38/botinki_heckel_alfa_120000101.php'=>'/specobuv/demisezonnaya_specobuv/botinki/botinki_HECKEL_alfa_120000101.php',
  '/catalog5/models38/botinki_heckel_makdjamp_sport_120002901.php'=>'/specobuv/demisezonnaya_specobuv/botinki/botinki_HECKEL_makdjamp_sport_120002901.php',
  '/catalog5/models38/botinki_heckel_makkross_120007701.php'=>'/specobuv/demisezonnaya_specobuv/botinki/botinki_HECKEL_makkross_120007701.php',
  '/catalog5/models366/polubotinki_treyl_dji_120013901.php'=>'/specobuv/demisezonnaya_specobuv/polubotinki_tufli/polubotinki_treyl_dji_120013901.php',
  '/catalog5/models133/tufli_toff_gera_120006002.php'=>'/specobuv/demisezonnaya_specobuv/polubotinki_tufli/tufli_toff_gera_120006002.php',
  '/catalog5/models133/polubotinki_toff_sparta_120008201.php'=>'/specobuv/demisezonnaya_specobuv/polubotinki_tufli/polubotinki_toff_sparta_120008201.php',
  '/catalog5/models10101/polubotinki_panda_ekstrim_42002_s3_120009201.php'=>'/specobuv/demisezonnaya_specobuv/polubotinki_tufli/polubotinki_PANDA_ekstrim_42002_S3_120009201.php',
  '/catalog5/models10101/polubotinki_panda_strong_professional_96670_s1_120012501.php'=>'/specobuv/demisezonnaya_specobuv/polubotinki_tufli/polubotinki_PANDA_strong_professional_96670_S1_120012501.php',
  '/catalog5/models38/polubotinki_heckel_tetra_120000201.php'=>'/specobuv/demisezonnaya_specobuv/polubotinki_tufli/polubotinki_HECKEL_tetra_120000201.php',
  '/catalog5/models38/polubotinki_heckel_makkross_120007601.php'=>'/specobuv/demisezonnaya_specobuv/polubotinki_tufli/polubotinki_HECKEL_makkross_120007601.php',
  '/catalog5/models38/polubotinki_heckel_makpuls_sport_120003001.php'=>'/specobuv/demisezonnaya_specobuv/polubotinki_tufli/polubotinki_HECKEL_makpuls_sport_120003001.php',
  '/catalog5/models366/sandalii_treyl_zomer_120014001.php'=>'/specobuv/demisezonnaya_specobuv/sandalii/sandalii_treyl_zomer_120014001.php',
  '/catalog5/models133/sandalii_toff_troya_120004701.php'=>'/specobuv/demisezonnaya_specobuv/sandalii/sandalii_toff_troya_120004701.php',
  '/catalog5/models10101/sandalii_panda_strong_6119_s1_120009101.php'=>'/specobuv/demisezonnaya_specobuv/sandalii/sandalii_PANDA_strong_6119_S1_120009101.php',
  '/catalog5/models41/sabo_lena_bez_remeshka_120006301.php'=>'/specobuv/demisezonnaya_specobuv/sabo_i_tapochki/sabo_lena_bez_remeshka_120006301.php',
  '/catalog5/models41/tapochki_eva_120001101.php'=>'/specobuv/demisezonnaya_specobuv/sabo_i_tapochki/tapochki_eva_120001101.php',
  '/catalog5/models37/botinki_heckel_asfalt_master_121000101.php'=>'/specobuv/termostoykaya_specobuv/botinki/botinki_HECKEL_asfalt_master_121000101.php',
  '/catalog5/models38/botinki_heckel_makstopak_121000501.php'=>'/specobuv/termostoykaya_specobuv/botinki/botinki_HECKEL_makstopak_121000501.php',
  '/catalog5/models37/botinki_heckel_makfonder_121003501.php'=>'/specobuv/termostoykaya_specobuv/dlya_metallurgov_i_svarshhikov/botinki_HECKEL_makfonder_121003501.php',
  '/catalog5/models37/polubotinki_makallegron_polikap_121001601.php'=>'/specobuv/termostoykaya_specobuv/polubotinki/polubotinki_HECKEL_makallegron_polikap_121001601.php',
  '/catalog5/models137/sapogi_irtysh_s_trehsloynym_chulkom_122003001.php'=>'/specobuv/uteplennaya_specobuv/dlya_osobogo_klimaticheskogo_poyasa/sapogi_irtysh_s_trehsloynym_chulkom_122003001.php',
  '/catalog5/models137/sapogi_mg_taymyr_s_chulkom_122003701.php'=>'/specobuv/uteplennaya_specobuv/sapogi/sapogi_MG_taymyr_s_chulkom_122003701.php',
  '/catalog5/models137/sapogi_mg_yamal_s_chulkom_122002901.php'=>'/specobuv/uteplennaya_specobuv/sapogi/sapogi_MG_yamal_s_chulkom_122002901.php',
  '/catalog5/models137/sapogi_treyl_polus_122005702.php'=>'/specobuv/uteplennaya_specobuv/sapogi/sapogi_treyl_polus_122005702.php',
  '/catalog5/models36/sapogi_rang_arktik_122001201.php'=>'/specobuv/uteplennaya_specobuv/sapogi/sapogi_rang_arktik_122001201.php',
  '/catalog5/models137/sapogi_treyl_grand_r_122002601.php'=>'/specobuv/uteplennaya_specobuv/sapogi/sapogi_treyl_grand_r_122002601.php',
  '/catalog5/models137/sapogi_toff_kamam_kojanye_122006701.php'=>'/specobuv/uteplennaya_specobuv/sapogi/sapogi_toff_kamam_kojanye_122006701.php',
  '/catalog5/models27/botinki_toff_kraft_122003301.php'=>'/specobuv/uteplennaya_specobuv/botinki/botinki_toff_kraft_122003301.php',
  '/catalog5/models40/botinki_vysokie_toff_berkutm_122006401.php'=>'/specobuv/uteplennaya_specobuv/botinki/botinki_vysokie_toff_berkutm_122006401.php',
  '/catalog5/models137/botinki_vysokie_treyl_vinter_120013501.php'=>'/specobuv/uteplennaya_specobuv/botinki/botinki_vysokie_treyl_vinter_120013501.php',
  '/catalog5/models40/botinki_vysokie_toff_omon_m_122006601.php'=>'/specobuv/uteplennaya_specobuv/botinki/botinki_vysokie_toff_omon_m_122006601.php',
  '/catalog5/models40/botinki_vysokie_toff_omonm_122006801.php'=>'/specobuv/uteplennaya_specobuv/botinki/botinki_vysokie_toff_omonm_122006801.php',
  '/catalog5/models137/valenki_122000301.php'=>'/specobuv/uteplennaya_specobuv/unty_valenki_bahily/valenki_122000301.php',
  '/catalog5/models137/valenki_obrezinennye_122000401.php'=>'/specobuv/uteplennaya_specobuv/unty_valenki_bahily/valenki_obrezinennye_122000401.php',
  '/catalog5/models137/sapogi_polyarnik_122001801.php'=>'/specobuv/uteplennaya_specobuv/unty_valenki_bahily/sapogi_polyarnik_122001801.php',
  '/catalog5/models137/unty_mehovye_122000801.php'=>'/specobuv/uteplennaya_specobuv/unty_valenki_bahily/unty_mehovye_122000801.php',
  '/catalog5/models41/sapogi_pvh_arte_17861_123001601.php'=>'/specobuv/vlagostoykaya_specobuv/specobuv_iz_pvh/sapogi_pvh_stal_200dj_123001601.php',
  '/catalog5/models41/sapogi_rezinovye_kshhs_123002001.php'=>'/specobuv/vlagostoykaya_specobuv/specobuv_iz_reziny/sapogi_rezinovye_kshhs_123002001.php',
  '/catalog5/models41/sapogi_arte_grafit_shahterskie_123002701.php'=>'/specobuv/vlagostoykaya_specobuv/specobuv_iz_reziny/sapogi_arte_grafit_shahterskie_123002701.php',
  '/catalog5/models41/sapogi_rezinovye_123001501.php'=>'/specobuv/vlagostoykaya_specobuv/specobuv_iz_reziny/sapogi_rezinovye_123001501.php',
  '/catalog5/models41/sapogi_rezinovye_rybackie_123000601.php'=>'/specobuv/vlagostoykaya_specobuv/specobuv_iz_reziny/sapogi_rezinovye_rybackie_123000601.php',
  '/catalog/models3320/boty_dielektricheskie_123000301.php'=>'/specobuv/vlagostoykaya_specobuv/specobuv_iz_reziny/boty_dielektricheskie_123000301.php',
  '/catalog5/models41/sapogi_nokian_evrologer_120006501.php'=>'/specobuv/vlagostoykaya_specobuv/specobuv_iz_reziny/sapogi_nokian_evrologer_120006501.php',
  '/catalog5/models41/sapogi_nokian_faerseyf_121000301.php'=>'/specobuv/vlagostoykaya_specobuv/specobuv_iz_reziny/sapogi_nokian_faerseyf_121000301.php',
  '/catalog5/models41/galoshi_na_valenki_123000201.php'=>'/specobuv/vlagostoykaya_specobuv/galoshi/galoshi_na_valenki_123000201.php',
  '/catalog5/models41/galoshi_sadovye_123000401.php'=>'/specobuv/vlagostoykaya_specobuv/galoshi/galoshi_sadovye_123000401.php',
  '/catalog6/models32/kaska_jsp_mk7_shahterskaya_130005701.php'=>'/sredstva_zashhity/zashhita_golovy/kaski_shahterskie/kaska_JSP_mk7_shahterskaya_130005701.php',
  '/catalog6/models134/ochki_uvex_ayvo_9160_131000102.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_UVEX_ayvo_9160_131000102.php',
  '/catalog6/models134/ochki_uvex_astrospek_9168_131002101.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_UVEX_astrospek_9168_131002101.php',
  '/catalog6/models134/ochki_uvex_astrospek_9168_131002102.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_UVEX_astrospek_9168_131002102.php',
  '/catalog6/models134/ochki_uvex_astrospek_9168_131002103.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_UVEX_astrospek_9168_131002103.php',
  '/catalog6/models134/ochki_uvex_astrofleks_9163_131002001.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_UVEX_astrofleks_9163_131002001.php',
  '/catalog6/models134/ochki_uvex_skayper_9195_131002302.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_UVEX_skayper_9195_131002302.php',
  '/catalog6/models134/ochki_uvex_vizitor_9161_131002501.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_UVEX_vizitor_9161_131002501.php',
  '/catalog6/models134/ochki_uvex_vizitor_9161_131002502.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_UVEX_vizitor_9161_131002502.php',
  '/catalog6/models134/ochki_uvex_ultraspek_9165_131002401.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_UVEX_ultraspek_9165_131002401.php',
  '/catalog6/models134/ochki_3m_peltor_maksim_131004001.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_PELTOR_maksim_131004001.php',
  '/catalog6/models134/ochki_3m_peltor_maksim_131004003.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_PELTOR_maksim_131004003.php',
  '/catalog6/models134/ochki_3m_2840_131003401.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_2840_131003401.php',
  '/catalog6/models134/ochki_3m_2841_131001601.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_2841_131001601.php',
  '/catalog6/models134/ochki_3m_2842_131001701.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_2842_131001701.php',
  '/catalog6/models134/ochki_3m_2820_131001301.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_2820_131001301.php',
  '/catalog6/models134/ochki_3m_2821_131001401.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_2821_131001401.php',
  '/catalog6/models134/ochki_3m_2822_131001501.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_2822_131001501.php',
  '/catalog6/models134/ochki_3m_2750_131003601.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_2750_131003601.php',
  '/catalog6/models134/ochki_3m_2751_131002701.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_2751_131002701.php',
  '/catalog6/models134/ochki_3m_2720_131000401.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_2720_131000401.php',
  '/catalog6/models134/ochki_3m_2721_131000501.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_2721_131000501.php',
  '/catalog6/models134/ochki_3m_2722_131000601.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_3M_2722_131000601.php',
  '/catalog6/models134/ochki_optex_vizi_131003701.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_OPTEX_vizi_131003701.php',
  '/catalog6/models134/ochki_optex_san_131003501.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_OPTEX_san_131003501.php',
  '/catalog6/models134/ochki_optex_sport_131001101.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_OPTEX_sport_131001101.php',
  '/catalog6/models134/ochki_uvex_ayvo_9160_131000105.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_otkrytye/ochki_UVEX_ayvo_9160_131000105.php',
  '/catalog6/models134/ochki_zakrytye_uvex_ultravijn_9301_131006307.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_zakrytye/ochki_zakrytye_UVEX_ultravijn_9301_131006307.php',
  '/catalog6/models134/ochki_zakrytye_uvex_ultravijn_9301_131006301.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_zakrytye/ochki_zakrytye_UVEX_ultravijn_9301_131006301.php',
  '/catalog6/models134/ochki_zakrytye_uvex_ultravijn_9301_131006304.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_zakrytye/ochki_zakrytye_UVEX_ultravijn_9301_131006304.php',
  '/catalog6/models134/shhitok_uvex_ultravijn_9301_131006401.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_zakrytye/shhitok_UVEX_ultravijn_9301_131006401.php',
  '/catalog6/models134/ochki_zakrytye_uvex_klassik_9305_131006201.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_zakrytye/ochki_zakrytye_UVEX_klassik_9305_131006201.php',
  '/catalog6/models134/ochki_zakrytye_uvex_ultrasonik_9302_131005903.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_zakrytye/ochki_zakrytye_UVEX_ultrasonik_9302_131005903.php',
  '/catalog6/models134/ochki_uvex_ultrasonik_9302_131026801.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_zakrytye/ochki_UVEX_ultrasonik_9302_131026801.php',
  '/catalog6/models134/ochki_zakrytye_jsp_kaspian_131006101.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_zakrytye/ochki_zakrytye_JSP_kaspian_131006101.php',
  '/catalog6/models134/ochki_zakrytye_optex_kemi_131005601.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_zakrytye/ochki_zakrytye_OPTEX_kemi_131005601.php',
  '/catalog6/models134/ochki_zakrytye_optex_opteks_131005801.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_zashhitnye_zakrytye/ochki_zakrytye_OPTEX_opteks_131005801.php',
  '/catalog6/models134/ochki_uvex_amigo_9350_131010201.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_dlya_svarochnyh_domennyh_i_prokatnyh_rabot/ochki_UVEX_amigo_9350_131010201.php',
  '/catalog6/models134/ochki_uvex_futura_9180_131010401.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_dlya_svarochnyh_domennyh_i_prokatnyh_rabot/ochki_UVEX_futura_9180_131010401.php',
  '/catalog6/models134/ochki_gazosvarshhika_131007801.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/ochki_dlya_svarochnyh_domennyh_i_prokatnyh_rabot/ochki_gazosvarshhika_131007801.php',
  '/catalog6/models134/nasos_uvex_9973_dlya_stancii_131009301.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/aksessuary/nasos_UVEX_9973_dlya_stancii_131009301.php',
  '/catalog6/models134/rastvor_uvex_9972_dlya_stancii_131011001.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/aksessuary/rastvor_UVEX_9972_dlya_stancii_131011001.php',
  '/catalog6/models134/salfetki_uvex_9971_dlya_stancii_131011801.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/aksessuary/salfetki_UVEX_9971_dlya_stancii_131011801.php',
  '/catalog6/models134/stanciya_uvex_9970_dlya_ochkov_131011701.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/aksessuary/stanciya_UVEX_9970_dlya_ochkov_131011701.php',
  '/catalog6/models134/chehol_uvex_9954_dlya_otkrytyh_ochkov_131009401.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/aksessuary/chehol_UVEX_9954_dlya_otkrytyh_ochkov_131009401.php',
  '/catalog6/models134/cheholsalfetka_uvex_9954_dlya_otkrytyh_ochkov_131010001.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/aksessuary/cheholsalfetka_UVEX_9954_dlya_otkrytyh_ochkov_131010001.php',
  '/catalog6/models134/shhitok_uvex_9726_na_kasku_131011501.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_zashhitnye/shhitok_UVEX_9726_na_kasku_131011501.php',
  '/catalog6/models134/shhitok_uvex_9722_na_kasku_131010701.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_zashhitnye/shhitok_UVEX_9722_na_kasku_131010701.php',
  '/catalog6/models134/shhitok_uvex_9727_na_kasku_131010501.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_zashhitnye/shhitok_UVEX_9727_na_kasku_131010501.php',
  '/catalog6/models134/adapter_sperian_supervizor_131009102.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_zashhitnye/adapter_HONEYWELL_supervizor_131009102.php',
  '/catalog6/models134/ekran_sperian_supervizor_1002312_131021901.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_zashhitnye/ekran_HONEYWELL_supervizor_1002312_131021901.php',
  '/catalog6/models134/ekran_sperian_supervizor_1002307_131022001.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_zashhitnye/ekran_HONEYWELL_supervizor_1002307_131022001.php',
  '/catalog6/models134/ekran_sperian_supervizor_1002330_131009204.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_zashhitnye/ekran_HONEYWELL_supervizor_1002330_131009204.php',
  '/catalog6/models134/ekran_sperian_supervizor_1002329_131022101.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_zashhitnye/ekran_HONEYWELL_supervizor_1002329_131022101.php',
  '/catalog6/models134/ekran_sperian_supervizor_metall_131009501.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_zashhitnye/ekran_HONEYWELL_supervizor_metall_131009501.php',
  '/catalog6/models134/adapter_sperian_supervizor_131009101.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_zashhitnye/adapter_HONEYWELL_supervizor_131009101.php',
  '/catalog6/models134/shhitok_uvex_9723_na_kasku_131010601.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_zashhitnye/shhitok_UVEX_9723_na_kasku_131010601.php',
  '/catalog6/models134/shhitok_nbt_131007701.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_zashhitnye/shhitok_nbt_131007701.php',
  '/catalog6/models134/plastina_zashhitnaya_3m_speedglas_narujnyaya_131014001.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_svarochnye/plastina_zashhitnaya_3M_SPEEDGLAS_narujnyaya_131014001.php',
  '/catalog6/models134/kryshka_zashhitnaya_3m_speedglas_432000_131016901.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_svarochnye/kryshka_zashhitnaya_3M_SPEEDGLAS_432000_131016901.php',
  '/catalog6/models134/ogolove_3m_speedglas_165010_131028801.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_svarochnye/ogolove_3M_SPEEDGLAS_165010_131028801.php',
  '/catalog6/models134/plenka_zashhitnaya_3m_speedglas_9000_131016501.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_svarochnye/plenka_zashhitnaya_3M_SPEEDGLAS_9000_131016501.php',
  '/catalog6/models134/podshlemnik_3m_speedglas_9000_131015301.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_svarochnye/podshlemnik_3M_SPEEDGLAS_9000_131015301.php',
  '/catalog6/models134/nakladka_na_ogolove_3m_speedglas_9100_168015_131023201.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_svarochnye/nakladka_na_ogolove_3M_SPEEDGLAS_9100_168015_131023201.php',
  '/catalog6/models134/shhitok_optrel_refleks_layt_131016201.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_svarochnye/shhitok_OPTREL_refleks_layt_131016201.php',
  '/catalog6/models134/shhitok_elektrosvarshhika_velder_131022201.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_svarochnye/shhitok_elektrosvarshhika_velder_131022201.php',
  '/catalog6/models134/linzy_smennye_3m_speedglas_171020_131031701.php'=>'/sredstva_zashhity/zashhita_glaz_i_lica/shhitki_svarochnye/linzy_smennye_3M_SPEEDGLAS_171020_131031701.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_3m_1100_132003002.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_3M_1100_132003002.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_3m_1110_132000801.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_3M_1110_132000801.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_3m_1120_132001301.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_3M_1120_132001301.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_3m_1130_132004201.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_3M_1130_132004201.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_3m_1261_132004101.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_3M_1261_132004101.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_3m_1271_132003501.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_3M_1271_132003501.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_3m_1310_132003201.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_3M_1310_132003201.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_3m_1311_132003301.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_3M_1311_132003301.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_howard_leight_maks_3301161_132006901.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_HONEYWELL_maks_3301161_132006901.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_howard_leight_maks_3301130_132000602.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_HONEYWELL_maks_3301130_132000602.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_howard_leight_matriks_1011236_132007101.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_HONEYWELL_matriks_1011236_132007101.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_howard_leight_lazer_layt_3301105_132000502.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_HONEYWELL_lazer_layt_3301105_132000502.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_howard_leight_lazer_layt_3301106_132006801.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_HONEYWELL_lazer_layt_3301106_132006801.php',
  '/catalog6/models33/vkladyshi_protivoshumnye_howard_leight_lazer_trak_3301167_132003401.php'=>'/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/vkladyshi_protivoshumnye_HONEYWELL_lazer_trak_3301167_132003401.php',
  '/catalog6/models33/naushniki_protivoshumnye_3m_peltor_optim_i_h510p3e405gu_na_kasku_132008001.php'=>'/sredstva_zashhity/zashhita_sluha/naushniki_protivoshumnye/naushniki_protivoshumnye_3M_PELTOR_optim_I_H510P3E405GU_na_kasku_132008001.php',
  '/catalog6/models33/naushniki_protivoshumnye_3m_peltor_optim_iii_h540a411sv_132001601.php'=>'/sredstva_zashhity/zashhita_sluha/naushniki_protivoshumnye/naushniki_protivoshumnye_3M_PELTOR_optim_III_H540A411SV_132001601.php',
  '/catalog6/models33/naushniki_protivoshumnye_3m_peltor_optim_i_hayviz_h510p3e469gb_na_kasku_132001802.php'=>'/sredstva_zashhity/zashhita_sluha/naushniki_protivoshumnye/naushniki_protivoshumnye_3M_PELTOR_optim_I_hayviz_H510P3E469GB_na_kasku_132001802.php',
  '/catalog6/models33/naushniki_protivoshumnye_3m_peltor_optim_ii_hayviz_h520a472gb_132005401.php'=>'/sredstva_zashhity/zashhita_sluha/naushniki_protivoshumnye/naushniki_protivoshumnye_3M_PELTOR_optim_II_hayviz_H520A472GB_132005401.php',
  '/catalog6/models33/naushniki_protivoshumnye_3m_peltor_optim_iii_hayviz_h540a461gb_132000102.php'=>'/sredstva_zashhity/zashhita_sluha/naushniki_protivoshumnye/naushniki_protivoshumnye_3M_PELTOR_optim_III_hayviz_H540A461GB_132000102.php',
  '/catalog6/models33/naushniki_protivoshumnye_3m_peltor_pro_tak_ii_mt15h7a2sv_132008701.php'=>'/sredstva_zashhity/zashhita_sluha/aktivnye_protivoshumnye_naushniki_i_naushniki_s_radiosvyazu/naushniki_protivoshumnye_3M_PELTOR_pro_tak_II_MT15H7A2SV_132008701.php',
  '/catalog6/models34/polumaska_filtruushhaya_3m_9310_133019601.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_respirator_3M_9310_133019601.php',
  '/catalog6/models34/polumaska_filtruushhaya_3m_9312_133019701.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_respirator_3M_9312_133019701.php',
  '/catalog6/models34/polumaska_filtruushhaya_3m_8101_133002301.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_respirator_3M_8101_133002301.php',
  '/catalog6/models34/polumaska_3m_8101_720_shtkor_31005099.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_respirator_3M_8101_720_shtkor_31005099.php',
  '/catalog6/models34/polumaska_filtruushhaya_3m_8710_133004401.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_respirator_3M_8710_133004401.php',
  '/catalog6/models34/polumaska_filtruushhaya_3m_9320_133019801.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_respirator_3M_9320_133019801.php',
  '/catalog6/models34/polumaska_filtruushhaya_3m_9322_133019501.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_respirator_3M_9322_133019501.php',
  '/catalog6/models34/polumaska_filtruushhaya_3m_8102_133004501.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_respirator_3M_8102_133004501.php',
  '/catalog6/models34/polumaska_3m_8102_720_shtkor_31005110.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_respirator_3M_8102_720_shtkor_31005110.php',
  '/catalog6/models34/polumaska_filtruushhaya_3m_9925_133001701.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_respirator_3M_9925_133001701.php',
  '/catalog6/models34/polumaska_filtruushhaya_3m_9332_133020001.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_respirator_3M_9332_133020001.php',
  '/catalog6/models34/polumaska_filtruushhaya_spirotek_sh3100_133003101.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_SPIROTEK_SH3100_133003101.php',
  '/catalog6/models34/polumaska_filtruushhaya_briz_1101_133005401.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_briz_1101_133005401.php',
  '/catalog6/models34/polumaska_filtruushhaya_u2k_133001001.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_u2k_133001001.php',
  '/catalog6/models34/polumaska_filtruushhaya_nevavk_133003601.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_nevavk_133003601.php',
  '/catalog6/models34/polumaska_filtruushhaya_alinaav_133003801.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_alinaav_133003801.php',
  '/catalog6/models34/polumaska_filtruushhaya_alinaa_133004701.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_alinaa_133004701.php',
  '/catalog6/models34/polumaska_filtruushhaya_alinap_133002401.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_alinap_133002401.php',
  '/catalog6/models34/polumaska_filtruushhaya_alinav_133004801.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_alinav_133004801.php',
  '/catalog6/models34/polumaska_filtruushhaya_f62sh_133000701.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/polumaska_filtruushhaya_f62sh_133000701.php',
  '/catalog6/models34/filtr_spirotek_a2p3_133018501.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivoaerozolnye/patron_SPIROTEK_F9000_133018501.php',
  '/catalog6/models34/polumaska_3m_7501_133005501.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/polumaska_respirator_3M_7501_133005501.php',
  '/catalog6/models34/polumaska_3m_7502_133009301.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/polumaska_respirator_3M_7502_133009301.php',
  '/catalog6/models34/polumaska_3m_7503_133008801.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/polumaska_respirator_3M_7503_133008801.php',
  '/catalog6/models34/polumaska_3m_6100_133008101.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/polumaska_respirator_3M_6100_133008101.php',
  '/catalog6/models34/polumaska_3m_6200_133009601.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/polumaska_respirator_3M_6200_133009601.php',
  '/catalog6/models34/polumaska_3m_6300_133008201.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/polumaska_respirator_3M_6300_133008201.php',
  '/catalog6/models34/maska_polnaya_3m_6700_133008301.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/maska_polnaya_respirator_3M_6700_133008301.php',
  '/catalog6/models134/maska_polnaya_3m_6800_133008401.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/maska_polnaya_respirator_3M_6800_133008401.php',
  '/catalog6/models34/maska_polnaya_3m_6900_133008501.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/maska_polnaya_respirator_3M_6900_133008501.php',
  '/catalog6/models34/patron_3m_6075_133009201.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/patron_3M_6075_133009201.php',
  '/catalog6/models34/predfiltr_3m_5911_133006801.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/predfiltr_3M_5911_133006801.php',
  '/catalog6/models34/predfiltr_3m_5925_133013301.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/predfiltr_3M_5925_133013301.php',
  '/catalog6/models34/filtr_3m_2135_133012801.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/filtr_3M_2135_133012801.php',
  '/catalog6/models34/derjatel_predfiltra_3m_501_133007801.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/derjatel_predfiltra_3M_501_133007801.php',
  '/catalog6/models34/polumaska_spirotek_hm8500_133013901.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/polumaska_SPIROTEK_HM8500_133013901.php',
  '/catalog6/models34/polumaska_spirotek_hm8500_133013902.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/polumaska_SPIROTEK_HM8500_133013902.php',
  '/catalog6/models34/polumaska_spirotek_hm8500_133013903.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/polumaska_SPIROTEK_HM8500_133013903.php',
  '/catalog6/models134/maska_polnaya_spirotek_fm9500_133010601.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/maska_polnaya_SPIROTEK_FM9500_133010601.php',
  '/catalog6/models34/maska_polnaya_spirotek_fm9000_133010502.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/maska_polnaya_SPIROTEK_FM9000_133010502.php',
  '/catalog6/models134/maska_polnaya_spirotek_fm9000_133010501.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/maska_polnaya_SPIROTEK_FM9000_133010501.php',
  '/catalog6/models34/polumaska_filtruushhaya_rpg67_133008001.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/polumaska_filtruushhaya_rpg67_133008001.php',
  '/catalog6/models34/polumaska_filtruushhaya_rpg67_133008004.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/polumaska_filtruushhaya_rpg67_133008004.php',
  '/catalog6/models34/polumaska_filtruushhaya_rpg67_133008002.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/polumaska_filtruushhaya_rpg67_133008002.php',
  '/catalog6/models34/patron_rpg67_133007901.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/patron_rpg67_133007901.php',
  '/catalog6/models34/patron_rpg67_133007902.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/patron_rpg67_133007902.php',
  '/catalog6/models34/patron_rpg67_133007903.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/patron_rpg67_133007903.php',
  '/catalog6/models34/protivogaz_gp7_133010201.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/protivogaz_gp7_133010201.php',
  '/catalog6/models34/patron_dpg3_s_gofrotrubkoy_k_pgazu_gp7_gp7v_133013701.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/patron_dpg3_s_gofrotrubkoy_k_pgazu_gp7_gp7v_133013701.php',
  '/catalog6/models34/maska_shmp_k_ppf_133009102.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/maska_shmp_k_ppf_133009102.php',
  '/catalog6/models34/maska_ppm88_k_ppf_133008701.php'=>'/sredstva_zashhity/zashhita_dyhaniya/filtruushhie_protivogazovye_i_protivogazoaerozolnye/maska_ppm88_k_ppf_133008701.php',
  '/catalog6/models34/protivogaz_ip6_133011501.php'=>'/sredstva_zashhity/zashhita_dyhaniya/izoliruushhie/protivogaz_ip6_133011501.php',
  '/catalog6/models34/protivogaz_ip4m_133012002.php'=>'/sredstva_zashhity/zashhita_dyhaniya/izoliruushhie/protivogaz_ip4m_133012002.php',
  '/catalog6/models34/protivogaz_pda_133012201.php'=>'/sredstva_zashhity/zashhita_dyhaniya/izoliruushhie/protivogaz_pda_133012201.php',
  '/catalog6/models74/kostum_trelleborg_trellkem_layt_tip_t_134000201.php'=>'/sredstva_zashhity/avariynospasatelnoe_snaryajenie/kostumy_izoliruushhie/kostum_ANSELL_trellkem_layt_tip_t_134000201.php',
  '/catalog4/models93/kostum_trelleborg_trellkem_splesh_600_134000301.php'=>'/sredstva_zashhity/avariynospasatelnoe_snaryajenie/kostumy_izoliruushhie/kostum_ANSELL_trellkem_splesh_600_134000301.php',
  '/catalog6/models30/pasta_evonik_solopol_137000602.php'=>'/sredstva_zashhity/zashhita_koji/pasta_EVONIK_solopol_137000602.php',
  '/catalog6/models30/pasta_evonik_solopol_137000601.php'=>'/sredstva_zashhity/zashhita_koji/pasta_EVONIK_solopol_137000601.php',
  '/catalog6/models30/krem_evonik_arretil_137000202.php'=>'/sredstva_zashhity/zashhita_koji/krem_EVONIK_arretil_137000202.php',
  '/catalog6/models30/krem_evonik_shtokolan_137002001.php'=>'/sredstva_zashhity/zashhita_koji/krem_EVONIK_shtokolan_137002001.php',
  '/catalog6/models30/krem_evonik_travabon_137002101.php'=>'/sredstva_zashhity/zashhita_koji/krem_EVONIK_travabon_137002101.php',
  '/catalog6/models30/krem_evonik_travabon_137002102.php'=>'/sredstva_zashhity/zashhita_koji/krem_EVONIK_travabon_137002102.php',
  '/catalog6/models30/krem_evonik_shtoko_emulsiya_137000501.php'=>'/sredstva_zashhity/zashhita_koji/krem_EVONIK_shtoko_emulsiya_137000501.php',
  '/catalog6/models30/krem_evonik_slig_special_137000701.php'=>'/sredstva_zashhity/zashhita_koji/pasta_EVONIK_slig_special_137000701.php',
  '/catalog6/models30/sprey_evonik_shtoko_fut_kea_137001201.php'=>'/sredstva_zashhity/zashhita_koji/sprey_EVONIK_shtoko_fut_kea_137001201.php',
  '/catalog6/models30/krem_evonik_shtoko_protekt_137002201.php'=>'/sredstva_zashhity/zashhita_koji/krem_EVONIK_shtoko_protekt_137002201.php',
  '/catalog6/models30/krem_evonik_reduran_special_137000802.php'=>'/sredstva_zashhity/zashhita_koji/pasta_EVONIK_reduran_special_137000802.php',
  '/catalog6/models30/krem_evonik_verapol_137002301.php'=>'/sredstva_zashhity/zashhita_koji/krem_EVONIK_verapol_137002301.php',
  '/catalog6/models30/gel_evonik_estesol_137000101.php'=>'/sredstva_zashhity/zashhita_koji/gel_EVONIK_estesol_137000101.php',
  '/catalog6/models30/gel_dlya_dusha_evonik_shtoko_hea_end_bodi_137001701.php'=>'/sredstva_zashhity/zashhita_koji/gel_dlya_dusha_EVONIK_shtoko_hea_end_bodi_137001701.php',
  '/catalog6/models30/gel_dlya_dusha_evonik_shtoko_hea_end_bodi_137001702.php'=>'/sredstva_zashhity/zashhita_koji/gel_dlya_dusha_EVONIK_shtoko_hea_end_bodi_137001702.php',
  '/catalog6/models30/dozator_evonik_shtoko_vario_svp_137000901.php'=>'/sredstva_zashhity/zashhita_koji/dozator_EVONIK_shtoko_vario_svp_137000901.php',
  '/catalog6/models30/dozator_evonik_shtoko_vario_ultra_137001101.php'=>'/sredstva_zashhity/zashhita_koji/dozator_EVONIK_shtoko_vario_ultra_137001101.php',
  '/catalog6/models30/dozator_evonik_shtoko_mat_vario_137001001.php'=>'/sredstva_zashhity/zashhita_koji/dozator_EVONIK_shtoko_mat_vario_137001001.php',
  '/catalog6/models30/krem_evonik_arretil_137000201.php'=>'/sredstva_zashhity/zashhita_koji/krem_EVONIK_arretil_137000201.php',
  '/catalog6/models30/krem_evonik_verapol_137002302.php'=>'/sredstva_zashhity/zashhita_koji/krem_EVONIK_verapol_137002302.php',
  '/catalog6/models30/krem_evonik_reduran_special_137000801.php'=>'/sredstva_zashhity/zashhita_koji/pasta_EVONIK_reduran_special_137000801.php',
  '/catalog6/models30/krem_evonik_slig_special_137000702.php'=>'/sredstva_zashhity/zashhita_koji/pasta_EVONIK_slig_special_137000702.php',
  '/catalog6/models30/krem_evonik_shtoko_protekt_137002202.php'=>'/sredstva_zashhity/zashhita_koji/krem_EVONIK_shtoko_protekt_137002202.php',
  '/catalog6/models30/krem_evonik_shtoko_emulsiya_137000502.php'=>'/sredstva_zashhity/zashhita_koji/krem_EVONIK_shtoko_emulsiya_137000502.php',
  '/catalog6/models73/privyaz_strahovochnaya_arx_ps3_138012001.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/privyaz_strahovochnaya_ARX_razm__PS3_138012001.php',
  '/catalog6/models73/privyaz_strahovochnaya_arx_ps4_138012101.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/privyaz_strahovochnaya_ARX_razm__PS4_138012101.php',
  '/catalog6/models73/privyaz_strahovochnaya_arx_ps5_138012201.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/privyaz_strahovochnaya_ARX_razm__PS5_138012201.php',
  '/catalog6/models73/strop_strahovochnyy_arx_ss1_138008901.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/strop_strahovochnyy_ARX_SS1_138008901.php',
  '/catalog6/models73/ustroystvo_blokiruushhee_arx_ub1_138008801.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/ustroystvo_blokiruushhee_ARX_UB1_138008801.php',
  '/catalog6/models73/ustroystvo_blokiruushhee_arx_ub2_138008802.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/ustroystvo_blokiruushhee_ARX_UB2_138008802.php',
  '/catalog6/models73/strop_reguliruemyy_arx_sr1_138009201.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/strop_reguliruemyy_ARX_SR1_138009201.php',
  '/catalog6/models73/poyas_predohranitelnyy_up01_138000501.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/poyas_predohranitelnyy_up01_138000501.php',
  '/catalog6/models73/poyas_predohranitelnyy_up01_strop_g_138000601.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/poyas_predohranitelnyy_up01_strop_g_138000601.php',
  '/catalog6/models73/sistema_uderjivaushhaya_uaa_138000401.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/sistema_uderjivaushhaya_uaa_138000401.php',
  '/catalog6/models73/sistema_uderjivaushhaya_uag_138000101.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/sistema_uderjivaushhaya_uag_138000101.php',
  '/catalog6/models73/poyas_predohranitelnyy_ppl32_138003301.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/poyas_predohranitelnyy_yaemz_ppl32_138003301.php',
  '/catalog6/models73/poyas_monterskiy_pm41_138003601.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/poyas_monterskiy_yaemz_pm41_138003601.php',
  '/catalog6/models73/poyas_monterskiy_pm40_138003701.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/poyas_monterskiy_yaemz_pm40_138003701.php',
  '/catalog6/models73/kogti_monterskie_138006201.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/kogti_monterskie_yaemz_138006201.php',
  '/catalog6/models73/kogti_monterskie_138006202.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/kogti_monterskie_yaemz_138006202.php',
  '/catalog6/models73/lazy_klm_138006301.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/lazy_yaemz_klm_138006301.php',
  '/catalog6/models73/lazy_klm_138006302.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/lazy_yaemz_klm_138006302.php',
  '/catalog6/models73/lazy_universalnye_lu1_138006401.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/lazy_yaemz_universalnye_lu1_138006401.php',
  '/catalog6/models73/strop_strahovochnyy_miller_me82_maniard_1005318_138003201.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/strop_strahovochnyy_MILLER_me82_maniard_1005318_138003201.php',
  '/catalog6/models73/poyas_pps_pojarnogo_147000101.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/poyas_pps_pojarnogo_147000101.php',
  '/catalog6/models73/shtativtrenoga_miller_mn10_1005041_138000801.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/shtativtrenoga_MILLER_mn10_1005041_138000801.php',
  '/catalog6/models73/lebedka_miller_mn20_1005042_138003401.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/lebedka_MILLER_mn20_1005042_138003401.php',
  '/catalog6/models73/liniya_ankernaya_miller_mn00_1002891_138007101.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/liniya_ankernaya_MILLER_mn00_1002891_138007101.php',
  '/catalog6/models73/privyaz_strahovochnaya_miller_komet_elastovik_138001101.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/privyaz_strahovochnaya_MILLER_komet_elastovik_138001101.php',
  '/catalog6/models73/strop_strahovochnyy_miller_amorstop_138002801.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/strop_strahovochnyy_MILLER_amorstop_138002801.php',
  '/catalog6/models73/krukkarabin_miller_go60_1018972_138004101.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/krukkarabin_MILLER_go60_1018972_138004101.php',
  '/catalog6/models73/kreplenie_miller_mdjey52_1018980_138004201.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/kreplenie_MILLER_mdjey52_1018980_138004201.php',
  '/catalog6/models73/petlya_krepejnaya_miller_mdjey00_138004401.php'=>'/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/petlya_krepejnaya_MILLER_mdjey00_138004401.php',
  '/catalog64/models86/germetik_kraevoy_3m_62556926608_145001801.php'=>'/sredstva_zashhity/protivoskolzyashhie_i_snijaushhie_ustalost_pokrytiya/germetik_kraevoy_3M_62556926608_145001801.php',
  '/catalog6/models92/lenta_protivoskolzyashhaya_3m_fn510041083_139000101.php'=>'/sredstva_zashhity/protivoskolzyashhie_i_snijaushhie_ustalost_pokrytiya/lenta_protivoskolzyashhaya_3M_FN520007769_139000101.php',
  '/catalog6/models42/perchatki_ansell_hayfleks_11900_136011401.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_ANSELL_hayfleks_11900_136011401.php',
  '/catalog6/models42/perchatki_ansell_haykron_27607_136010801.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_ANSELL_haykron_27607_136010801.php',
  '/catalog6/models42/perchatki_ansell_haykron_27602_136010701.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_ANSELL_haykron_27602_136010701.php',
  '/catalog6/models42/perchatki_ansell_haykron_27600_136001901.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_ANSELL_haykron_27600_136001901.php',
  '/catalog6/models42/perchatki_ansell_haylayt_47400_136001102.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_ANSELL_haylayt_47400_136001102.php',
  '/catalog6/models42/perchatki_ansell_hayfleks_11600_136011601.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_ANSELL_hayfleks_11600_136011601.php',
  '/catalog6/models42/perchatki_ansell_sensilayt_136000301.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_ANSELL_sensilayt_136000301.php',
  '/catalog6/models42/perchatki_ansell_fayber_taf_136005601.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_ANSELL_fayber_taf_136005601.php',
  '/catalog6/models42/perchatki_ansell_gladiator_16500_136010601.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_ANSELL_gladiator_16500_136010601.php',
  '/catalog6/models42/perchatki_vostochnye_tigry_g131_136007201.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_vostochnye_tigry_G131_136007201.php',
  '/catalog6/models42/perchatki_vostochnye_tigry_g132_136007301.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_vostochnye_tigry_G132_136007301.php',
  '/catalog6/models42/perchatki_vostochnye_tigry_g133_136006101.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_vostochnye_tigry_G133_136006101.php',
  '/catalog6/models42/perchatki_vostochnye_tigry_g135_136000401.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_vostochnye_tigry_G135_136000401.php',
  '/catalog6/models42/perchatki_spec_g137_136007401.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_spec_G137_136007401.php',
  '/catalog6/models42/perchatki_fors_g139_136008001.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_fors_G139_136008001.php',
  '/catalog6/models10102/perchatki_cerva_virdis_136012201.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_CERVA_virdis_136012201.php',
  '/catalog6/models10102/perchatki_cerva_banting_evolushn_136015602.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_CERVA_banting_evolushn_136015602.php',
  '/catalog6/models10102/perchatki_cerva_banting_evolushn_136015601.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_CERVA_banting_evolushn_136015601.php',
  '/catalog6/models10102/perchatki_cerva_bustard_136004401.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_CERVA_bustard_136004401.php',
  '/catalog6/models10102/perchatki_cerva_falkon_136012501.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_CERVA_falkon_136012501.php',
  '/catalog6/models10102/perchatki_cerva_koraks_136012302.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_CERVA_koraks_136012302.php',
  '/catalog6/models10102/perchatki_cerva_banting_136004202.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_CERVA_banting_136004202.php',
  '/catalog6/models10102/perchatki_cerva_banting_136004203.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_CERVA_banting_136004203.php',
  '/catalog6/models10102/perchatki_cerva_bobbi_135010_136014801.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_CERVA_bobbi_135010_136014801.php',
  '/catalog6/models42/perchatki_lateko_136014001.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_lateko_136014001.php',
  '/catalog42/models10080/perchatki_torro_136006701.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_torro_136006701.php',
  '/catalog6/models42/perchatki_fort_136010301.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_fort_trikotajnye_pvh_136010301.php',
  '/catalog6/models42/perchatki_g354_136002901.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_G354_136002901.php',
  '/catalog6/models42/perchatki_g304_136006001.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_G304_136006001.php',
  '/catalog6/models42/perchatki_g370_136008701.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_G370_136008701.php',
  '/catalog6/models42/perchatki_trikotajnye_s_pvh_136002601.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_trikotajnye_pvh_s_pokr__tochka_razm_10_136002601.php',
  '/catalog6/models42/perchatki_trikotajnye_s_pvh_136002602.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_trikotajnye_pvh_s_pokr__tochka_razm_9_136002602.php',
  '/catalog6/models42/perchatki_trikotajnye_136002701.php'=>'/zashhita_ruk/perchatki_mehanicheski_stoykie/perchatki_trikotajnye_136002701.php',
  '/catalog42/models10077/perchatki_ansell_vinter_manki_grip_23173_136001001.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_ANSELL_vinter_manki_grip_23173_136001001.php',
  '/catalog42/models10077/perchatki_ansell_vinter_manki_grip_23191_136011901.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_ANSELL_vinter_manki_grip_23191_136011901.php',
  '/catalog42/models10077/perchatki_ansell_polar_grip_136000801.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_ANSELL_polar_grip_136000801.php',
  '/catalog42/models10078/perchatki_ansell_kruzeyder_fleks_136006301.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_ANSELL_kruzeyder_fleks_136006301.php',
  '/catalog42/models10078/perchatki_ansell_merkuri_136005701.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_ANSELL_merkuri_136005701.php',
  '/catalog42/models10078/perchatki_ansell_neptun_kevlar_136000601.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_ANSELL_neptun_kevlar_136000601.php',
  '/catalog42/models10078/kragi_vostochnye_tigry_g128_136003601.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/kragi_vostochnye_tigry_G128_136003601.php',
  '/catalog42/models10078/kragi_vostochnye_tigry_g129_136006601.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/kragi_vostochnye_tigry_G129_136006601.php',
  '/catalog6/models42/perchatki_vostochnye_tigry_netkanyy_material_g130_136003701.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_vostochnye_tigry_netkanyy_material_G130_136003701.php',
  '/catalog6/models42/perchatki_vostochnye_tigry_g134_136003801.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_vostochnye_tigry_G134_136003801.php',
  '/catalog42/models10078/kragi_g340_136008601.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/kragi_G340_136008601.php',
  '/catalog42/models10078/kragi_g540_136000901.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/kragi_G540_136000901.php',
  '/catalog42/models10077/perchatki_aleuty_136006901.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_aleuty_136006901.php',
  '/catalog42/models10077/perchatki_hakasy_136000101.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_hakasy_136000101.php',
  '/catalog42/models10077/varejki_evenki_136000201.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/varejki_evenki_136000201.php',
  '/catalog42/models10077/perchatki_vinter_136005301.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_vinter_136005301.php',
  '/catalog42/models10077/perchatki_vinter_super_hant_g144_136005401.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_vinter_super_hant_G144_136005401.php',
  '/catalog42/models10077/perchatki_vinter_hant_136003401.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_vinter_hant_136003401.php',
  '/catalog6/models42/perchatki_kojanye_136004801.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_kojanye_136004801.php',
  '/catalog6/models42/perchatki_polusherstyanye_136005101.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_polusherstyanye_dvoynye_136005101.php',
  '/catalog42/models10077/perchatki_akrolayt_136007701.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/perchatki_akrolayt_136007701.php',
  '/catalog42/models10078/kragi_spilkovye_g46_136008401.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/kragi_spilkovye_G46_136008401.php',
  '/catalog64/models89/kragi_termostoykie_pojarnye_136010201.php'=>'/zashhita_ruk/ot_povyshennyh_i_ponijennyh_temperatur/kragi_termostoykie_pojarnye_136010201.php',
  '/catalog42/models10083/perchatki_ansell_alfatek_136003501.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_ANSELL_alfatek_136003501.php',
  '/catalog6/models42/perchatki_ansell_solveks_136004102.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_ANSELL_solveks_136004102.php',
  '/catalog42/models10083/perchatki_ansell_baykolor_136007901.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_ANSELL_baykolor_136007901.php',
  '/catalog42/models10083/perchatki_ansell_ekstra_136005201.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_ANSELL_ekstra_136005201.php',
  '/catalog42/models10083/perchatki_ansell_ekonohends_136002301.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_ANSELL_ekonohends_136002301.php',
  '/catalog42/models10083/perchatki_ansell_universal_136002401.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_ANSELL_universal_136002401.php',
  '/catalog42/models10083/perchatki_ansell_konform_69140_136005901.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_ANSELL_konform_69140_136005901.php',
  '/catalog42/models10083/perchatki_ansell_neotop_136002501.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_ANSELL_neotop_136002501.php',
  '/catalog42/models10083/perchatki_ansell_tach_i_taf_136006401.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_ANSELL_tach_i_taf_136006401.php',
  '/catalog42/models10083/perchatki_ansell_neotach_136003101.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_ANSELL_neotach_136003101.php',
  '/catalog42/models10083/perchatki_kshhs_tip_1_136005801.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_kshhs_tip_1_136005801.php',
  '/catalog42/models10083/perchatki_mbs_136007601.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_nms_136007601.php',
  '/catalog42/models10081/perchatki_rezinovye_bytovye_136006501.php'=>'/zashhita_ruk/perchatki_himicheski_stoykie_i_laboratornye/perchatki_rezinovye_bytovye_136006501.php',
  '/catalog42/models10076/perchatki_dielektricheskie_besshovnye_136002101.php'=>'/zashhita_ruk/perchatki_dielektricheskie/perchatki_dielektricheskie_besshovnye_136002101.php',
  '/catalog6/models42/rukavicy_g13_136004901.php'=>'/zashhita_ruk/rukavicy/rukavicy_G13_136004901.php',
  '/catalog6/models42/rukavicy_g12_136001601.php'=>'/zashhita_ruk/rukavicy/rukavicy_G12_136001601.php',
  '/catalog6/models42/rukavicy_g17_136001301.php'=>'/zashhita_ruk/rukavicy/rukavicy_G17_136001301.php',
  '/catalog6/models42/rukavicy_g26_136005001.php'=>'/zashhita_ruk/rukavicy/rukavicy_G26_136005001.php',
  '/catalog42/models10078/vachegi_g24_136008101.php'=>'/zashhita_ruk/rukavicy/vachegi_G24_136008101.php',
  '/catalog42/models10077/rukavicy_mehovye_136006801.php'=>'/zashhita_ruk/rukavicy/rukavicy_mehovye_136006801.php',
  '/catalog6/models42/rukavicy_g14_136007501.php'=>'/zashhita_ruk/rukavicy/rukavicy_G14_136007501.php',
  '/catalog6/models42/rukavicy_rezinotkanevye_136008501.php'=>'/zashhita_ruk/rukavicy/rukavicy_rezinotkanevye_136008501.php',
  '/catalog6/models42/rukavicy_g18_136001201.php'=>'/zashhita_ruk/rukavicy/rukavicy_G18_136001201.php',
  '/catalog6/models42/rukavicy_g16_136001701.php'=>'/zashhita_ruk/rukavicy/rukavicy_G16_136001701.php',
  '/catalog6/models42/rukavicy_g11_136001501.php'=>'/zashhita_ruk/rukavicy/rukavicy_G11_136001501.php',
  '/catalog6/models42/rukavicy_g47_136001401.php'=>'/zashhita_ruk/rukavicy/rukavicy_G47_136001401.php',
  '/catalog42/models10079/perchatki_ansell_vibragard_07111_136002002.php'=>'/zashhita_ruk/perchatki_vibrozashhitnye/perchatki_ANSELL_vibragard_07111_136002002.php',
  '/catalog42/models10079/perchatki_ansell_vibragard_07112_136011501.php'=>'/zashhita_ruk/perchatki_vibrozashhitnye/perchatki_ANSELL_vibragard_07112_136011501.php',
  '/catalog64/models139/aptechka_pervoy_pomoshhi_fest_avtomobilnaya_141002001.php'=>'/drugoe/dovrachebnaya_pomoshh/pervaya_pomoshh/aptechka_pervoy_pomoshhi_fest_avtomobilnaya_141002001.php',
  '/catalog64/models139/aptechka_appolo_dlya_okazaniya_pervoy_pomoshhi_141005801.php'=>'/drugoe/dovrachebnaya_pomoshh/pervaya_pomoshh/aptechka_dlya_okazaniya_pervoy_pomoshhi_141005801.php',
  '/catalog64/models86/veha_sterjnevaya_vs1_142000401.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/veha_sterjnevaya_vs1_142000401.php',
  '/catalog64/models86/veha_sterjnevaya_vs3_142000501.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/veha_sterjnevaya_vs3_142000501.php',
  '/catalog64/models65/znaki_vhod_142005001.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_vhod_142005001.php',
  '/catalog64/models65/znaki_vyhodit_zdes_levostoron__142006201.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_vyhodit_zdes_levostoron__142006201.php',
  '/catalog64/models65/znaki_vyhodit_zdes_pravostoron__142004501.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_vyhodit_zdes_pravostoron__142004501.php',
  '/catalog64/models65/znaki_zapreshhaetsya_kurit_142001901.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_zapreshhaetsya_kurit_142001901.php',
  '/catalog64/models65/znaki_zapreshhaetsya_polz_otkr_ognem_142003101.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_zapreshhaetsya_polz_otkr_ognem_142003101.php',
  '/catalog64/models65/znaki_zapreshhaetsya_tushit_vodoy_142006301.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_zapreshhaetsya_tushit_vodoy_142006301.php',
  '/catalog64/models65/znaki_mesto_kureniya_142002001.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_mesto_kureniya_142002001.php',
  '/catalog64/models65/znaki_ne_zagromojdat_prohod_142003401.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_ne_zagromojdat_prohod_142003401.php',
  '/catalog64/models65/znaki_o_pojare_zvonit_01_142002301.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_o_pojare_zvonit_101_142002301.php',
  '/catalog64/models65/znaki_ognetushitel_142002401.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_ognetushitel_142002401.php',
  '/catalog64/models65/znaki_ostorojno_edkie_veshhestva_142003701.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_ostorojno_edkie_veshhestva_142003701.php',
  '/catalog64/models65/znaki_ostorojno_opasnost_vzryva_142003601.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_ostorojno_opasnost_vzryva_142003601.php',
  '/catalog64/models65/znaki_ostorojno_prochie_opasnosti_142003901.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_ostorojno_prochie_opasnosti_142003901.php',
  '/catalog64/models65/znaki_ostorojno_rabotaet_kran_142003801.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_ostorojno_rabotaet_kran_142003801.php',
  '/catalog64/models65/znaki_ostorojno_yadovitye_veshhestva_142006401.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_ostorojno_yadovitye_veshhestva_142006401.php',
  '/catalog64/models65/znaki_ostorojnolegkovosp__veshhva_142003501.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_ostorojnolegkovosp__veshhva_142003501.php',
  '/catalog64/models65/znaki_pojarnyy_vodoistochnik_142004401.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_pojarnyy_vodoistochnik_142004401.php',
  '/catalog64/models65/znaki_pojarnyy_gidrant_142003001.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_pojarnyy_gidrant_142003001.php',
  '/catalog64/models65/znaki_pojarnyy_kran_142002501.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_pojarnyy_kran_142002501.php',
  '/catalog64/models65/znaki_prohod_derjat_svobodnym_142004301.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_prohod_derjat_svobodnym_142004301.php',
  '/catalog64/models65/znaki_rabotat_v_zashhitnoy_obuvi_142004001.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_rabotat_v_zashhitnoy_obuvi_142004001.php',
  '/catalog64/models65/znaki_rabotat_v_zashhitnoy_odejde_142006501.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_rabotat_v_zashhitnoy_odejde_142006501.php',
  '/catalog64/models65/znaki_rabotat_v_zashhitnyh_ochkah_142004101.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_rabotat_v_zashhitnyh_ochkah_142004101.php',
  '/catalog64/models65/znaki_rabotat_v_zashhitnyh_perchatkah_142002901.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_rabotat_v_zashhitnyh_perchatkah_142002901.php',
  '/catalog64/models65/znaki_rabotat_v_kaske_142006601.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_rabotat_v_kaske_142006601.php',
  '/catalog64/models65/znaki_rabotat_v_predohr__poyase_142004201.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_rabotat_v_predohr__poyase_142004201.php',
  '/catalog64/models65/znaki_rabotat_zdes_142006001.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/znaki_rabotat_zdes_142006001.php',
  '/catalog64/models86/konus_ks15_s_odnoy_sv_polosoy_142001001.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/konus_ks15_s_odnoy_sv_polosoy_142001001.php',
  '/catalog64/models86/konus_ks16_s_odnoy_sv_polosoy_142000701.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/konus_ks16_s_odnoy_sv_polosoy_142000701.php',
  '/catalog64/models86/konus_ks26_s_odnoy_sv_polosoy_142000901.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/konus_ks26_s_odnoy_sv_polosoy_142000901.php',
  '/catalog64/models86/konus_ks28_s_dvumya_sv_polosami_142000801.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/konus_ks28_s_dvumya_sv_polosami_142000801.php',
  '/catalog64/models86/konus_ograditelnyy_ks1_4_142001101.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/konus_ograditelnyy_ks1_4_142001101.php',
  '/catalog64/models86/konus_ograditelnyy_ks2_4_142001201.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/konus_ograditelnyy_ks2_4_142001201.php',
  '/catalog64/models86/setka_plastikovaya_142001301.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/setka_plastikovaya_142001301.php',
  '/catalog64/models86/fonar_signalnyy_fs4_142001601.php'=>'/drugoe/ograjdeniya_i_znaki_bezopasnosti/fonar_signalnyy_fs4_142001601.php',
  '/catalog64/models138/polotence_h18_143000901.php'=>'/drugoe/tekstil_i_postelnye_prinadlejnosti/polotence_h18_143000901.php',
  '/catalog64/models86/lenta_signalnaya_144001602.php'=>'/drugoe/hozyaystvennye_tovary/lenta_signalnaya_144001602.php',
  '/catalog64/models86/lenta_signalnaya_144001601.php'=>'/drugoe/hozyaystvennye_tovary/lenta_signalnaya_144001601.php',
  '/catalog64/models138/vedro_ocinkovannoe_144000701.php'=>'/drugoe/hozyaystvennye_tovary/vedro_ocinkovannoe_144000701.php',
  '/catalog64/models138/venik_144000901.php'=>'/drugoe/hozyaystvennye_tovary/venik_144000901.php',
  '/catalog64/models138/grabli_veernye_144000501.php'=>'/drugoe/hozyaystvennye_tovary/grabli_veernye_144000501.php',
  '/catalog64/models138/lopata_sovkovaya_144001801.php'=>'/drugoe/hozyaystvennye_tovary/lopata_sovkovaya_144001801.php',
  '/catalog64/models138/lopata_shtykovaya_144002401.php'=>'/drugoe/hozyaystvennye_tovary/lopata_shtykovaya_144002401.php',
  '/catalog64/models138/shhetkasmetka_144000601.php'=>'/drugoe/hozyaystvennye_tovary/shhetkasmetka_144000601.php',
  '/catalog64/models138/shvabra_144002001.php'=>'/drugoe/hozyaystvennye_tovary/shvabra_144002001.php',
  '/catalog64/models138/lopata_snegovaya_144001701.php'=>'/drugoe/hozyaystvennye_tovary/lopata_snegovaya_144001701.php',
  '/specodezhda.php' => '/specodejda/',
  '/catalog4/' => '/specodejda/',
  '/catalog4/models17/' => '/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/',
  '/catalog4/models12/' => '/specodejda/zashhita_ot_ponijennyh_temperatur/',
  '/catalog4/models132' => '/specodejda/signalnaya_odejda/',
  '/catalog4/models14/' => '/specodejda/zashhita_ot_povyshennyh_temperatur/',
  '/catalog4/models15/' => '/specodejda/zashhita_ot_vlagi/',
  '/catalog4/models10085/' => '/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/',
  '/catalog4/models107/' => '/specodejda/odejda_v_stile_militari/dlya_ohrannyh_struktur/',
  '/catalog10087/' => '/specodejda/odejda_v_stile_militari/dlya_rybalki_ohoty_turizma_aktivnogo_otdyha/',
  '/catalog4/models93/' => '/specodejda/zashhita_ot_nefti_i_nefteproduktov/',
  '/catalog4/models108/' => '/specodejda/zashhita_ot_kislot_i_shhelochey/',
  '/catalog4/models135/' => '/specodejda/zashhita_ot_elektrodugi/',
  '/catalog5/' => '/specobuv/',
  '/catalog6/' => '/sredstva_zashhity/',
  '/catalog6/models32/' => '/sredstva_zashhity/zashhita_golovy/',
  '/catalog6/models134/' => '/sredstva_zashhity/zashhita_glaz_i_lica/',
  '/catalog6/models33/' => '/sredstva_zashhity/zashhita_sluha/',
  '/catalog6/models33/' => '/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/',
  '/catalog6/models33/' => '/sredstva_zashhity/zashhita_sluha/naushniki_protivoshumnye/',
  '/catalog6/models34/' => '/sredstva_zashhity/zashhita_dyhaniya/',
  '/catalog6/models74/' => '/sredstva_zashhity/avariynospasatelnoe_snaryajenie/',
  '/catalog6/models30/' => '/sredstva_zashhity/zashhita_koji/',
  '/catalog6/models73/' => '/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/',
  '/catalog6/models92/' => '/sredstva_zashhity/protivoskolzyashhie_i_snijaushhie_ustalost_pokrytiya/',
  '/catalog6/models42/' => '/zashhita_ruk/',
  '/catalog64/' => '/drugoe/',
  '/catalog64/models86/' => '/drugoe/ograjdeniya_i_znaki_bezopasnosti/',
  '/catalog64/models138/' => '/drugoe/hozyaystvennye_tovary/',
  '/catalog4' => '/specodejda/',
  '/catalog4/models17' => '/specodejda/zashhita_ot_obshhih_proizvodstvennyh_zagryazneniy/',
  '/catalog4/models12' => '/specodejda/zashhita_ot_ponijennyh_temperatur/',
  '/catalog4/models13' => '/specodejda/signalnaya_odejda/',
  '/catalog4/models14' => '/specodejda/zashhita_ot_povyshennyh_temperatur/',
  '/catalog4/models15' => '/specodejda/zashhita_ot_vlagi/',
  '/catalog4/models10085' => '/specodejda/dlya_rabotnikov_servisnyh_predpriyatiy/dlya_medicinskih_uchrejdeniy/',
  '/catalog4/models107' => '/specodejda/odejda_v_stile_militari/dlya_ohrannyh_struktur/',
  '/catalog10087' => '/specodejda/odejda_v_stile_militari/dlya_rybalki_ohoty_turizma_aktivnogo_otdyha/',
  '/catalog4/models93' => '/specodejda/zashhita_ot_nefti_i_nefteproduktov/',
  '/catalog4/models108' => '/specodejda/zashhita_ot_kislot_i_shhelochey/',
  '/catalog4/models135' => '/specodejda/zashhita_ot_elektrodugi/',
  '/catalog5' => '/specobuv/',
  '/catalog6' => '/sredstva_zashhity/',
  '/catalog6/models32' => '/sredstva_zashhity/zashhita_golovy/',
  '/catalog6/models134' => '/sredstva_zashhity/zashhita_glaz_i_lica/',
  '/catalog6/models33' => '/sredstva_zashhity/zashhita_sluha/',
  '/catalog6/models33' => '/sredstva_zashhity/zashhita_sluha/vkladyshi_protivoshumnye/',
  '/catalog6/models33' => '/sredstva_zashhity/zashhita_sluha/naushniki_protivoshumnye/',
  '/catalog6/models34' => '/sredstva_zashhity/zashhita_dyhaniya/',
  '/catalog6/models74' => '/sredstva_zashhity/avariynospasatelnoe_snaryajenie/',
  '/catalog6/models30' => '/sredstva_zashhity/zashhita_koji/',
  '/catalog6/models73' => '/sredstva_zashhity/zashhita_ot_padeniy_s_vysoty/',
  '/catalog6/models92' => '/sredstva_zashhity/protivoskolzyashhie_i_snijaushhie_ustalost_pokrytiya/',
  '/catalog6/models42' => '/zashhita_ruk/',
  '/catalog64' => '/drugoe/',
  '/catalog64/models86' => '/drugoe/ograjdeniya_i_znaki_bezopasnosti/',
  '/catalog64/models138' => '/drugoe/hozyaystvennye_tovary/'
);

            $where = array_key_exists($_SERVER['REQUEST_URI'], $studio_catalog_common)!==false ? $studio_catalog_common[$_SERVER['REQUEST_URI']] : '/';
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: {$where}");
	   exit(0);	
        }

	$endp = strrpos($_SERVER["REQUEST_URI"], '?');		
	if($endp)		
		$_SERVER["REQUEST_URI"] = substr($_SERVER["REQUEST_URI"], 0, $endp);

	if($_SERVER["REQUEST_URI"] == '/shops/')
		$_SERVER["REQUEST_URI"] = '/coords_store.php';

	require "new_admin/functions.php";

	$GLOBALS['PAGE_TYPE'] = 'page';
	dbconnect();
	$GLOBALS['DB_CONNECTION'] = dbconnect_new();
		
	$GLOBALS['PAGE_KEY'] = get_ii_page_params();
  $GLOBALS['PAGE_KEY'] = str_replace ('?'.$_SERVER['QUERY_STRING'],'',$GLOBALS['PAGE_KEY']);
 
  if(isset($_REQUEST['get_cart']))
  {
    echo get_cart();
    exit;
  }
  if(isset($_REQUEST['add_to_cart']))
  {
    echo add_to_cart();
    exit;
  }
  else if(isset($_REQUEST['cleanup_cart']))  {
    empty_cart();
  }
    
  if(isset($_REQUEST['remove_cart'])) {
    remove_to_cart();
  } else if(isset($_REQUEST['remove_size_from_cart'])){
    remove_size_from_cart ();
  } else if(isset($_REQUEST['update_quantity'])){
   update_quantity ();
  } else if(isset($_REQUEST['add_size'])){
    add_size ();
  } else if(isset($_REQUEST['update_size'])){
    update_size ();
  }

  get_common_count();

  draw($GLOBALS['PAGE_KEY']);

function get_ii_page_params()
{	
  if (strpos($_SERVER["REQUEST_URI"],'/zakaz_i_dostavka.html')!==FALSE){
    $GLOBALS['PAGE_TYPE'] = 'page';
    return 'zakaz_i_dostavka';
   }

	if($_SERVER["REQUEST_URI"] == '/' || $_SERVER["REQUEST_URI"] == '') 
		return '/index.html';

	if($_SERVER["REQUEST_URI"] == '/coords_store.php') 
		return $_SERVER["REQUEST_URI"];

	if (strpos($_SERVER["REQUEST_URI"], '/madeby/') !== FALSE)
	{
		$GLOBALS['PAGE_TYPE'] = 'madeby';
		$GLOBALS['CATALOG_INFO'] = array();
		return 'catalog';
	}
  if (strpos($_SERVER["REQUEST_URI"], '/carlsberg/factories/') !== FALSE || $_SERVER["REQUEST_URI"] == '/carlsberg/') {
      $GLOBALS['PAGE_TYPE'] = "category";  
      return 'catalog_carlsberg';
  }
	if (strpos($_SERVER["REQUEST_URI"], '/internet_magazin/') !== FALSE)
	{
		$GLOBALS['PAGE_TYPE'] = 'ishop';
		$GLOBALS['CATALOG_INFO'] = array();
		return 'catalog';
	}

	if(strpos($_SERVER["REQUEST_URI"], '.php'))
	{
    $table_catalog = 'studio_catalog';
    $table_catalog_groups = 'studio_catalog_groups';
    $postfix = '';
    $url_item = $_SERVER["REQUEST_URI"];
    if (strpos($_SERVER["REQUEST_URI"], '/carlsberg/') !== FALSE) {
      $table_catalog = 'studio_catalog_carslberg';
      $table_catalog_groups = 'studio_catalog_groups_carslberg';
      $postfix = '_carlsberg';
      $url_item = str_replace('/carlsberg', '', $_SERVER["REQUEST_URI"]);
    }
    $query = "SELECT sc.*,cg.g1title,cg.g2title,cg.g3title,cg.g1_latin,cg.g2_latin,cg.g3_latin,cg.tlevel
              from {$table_catalog} as sc inner join {$table_catalog_groups} as cg on sc.gid=cg.code 
              where sc.title_latin='{$url_item}' limit 1";

		$r = $GLOBALS['DB_CONNECTION']->query($query);
	 	if($r)
		{
			$row = $r->fetch_assoc();
			if($row)
			{
				$GLOBALS['PAGE_TYPE'] = 'tovar';
				$GLOBALS['CATALOG_INFO'] = $row;
				return 'catalog'.$postfix;
			}
		}
	}
	else if(!strpos($_SERVER["REQUEST_URI"], '.html'))
	{
		$r = $GLOBALS['DB_CONNECTION']->query("SELECT * from studio_catalog_groups where g3_latin='{$_SERVER["REQUEST_URI"]}' limit 1");
	 	if($r)
		{
			$row = $r->fetch_assoc();
			if($row)
			{
				$GLOBALS['PAGE_TYPE'] = 'category';
				$GLOBALS['CATALOG_INFO'] = $row;
				return 'catalog';
			}
		}
	}
	
	return $_SERVER["REQUEST_URI"];
}

function empty_cart()
  {
    $order_id = get_sid();
    unset($_SESSION['II_SID']);
    $GLOBALS['DB_CONNECTION']->query("delete from cms2_cart where session_id='$order_id'");
  }

function get_common_count () {
  $type = $_SESSION['auto_user']['type'] ? 'carlsberg' :'';
  $order_id = get_sid();
  
  $query = "select sum(quantity) as common_count,1
            from cms2_cart
          where session_id='$order_id' and cart_item_id <> 0  and type = ''";
  if ($type) {
    $query .=  "union all 
                select sum(quantity) as common_count_carlsberg,2
                from cms2_cart
                where session_id='$order_id'  and cart_item_id <> 0 and type = '{$type}'";
  }
    $GLOBALS['common_count'] = '0';
     $GLOBALS['common_count_carlsberg'] = '0';
    $r = $GLOBALS['DB_CONNECTION']->query($query);
    while($r&&$row = $r->fetch_assoc())
    {
      if ($row['1']==1) {
        $GLOBALS['common_count']  = $row['common_count'];  
      } else {
        $GLOBALS['common_count_carlsberg']  = $row['common_count'];  
      }
      
    }
}
   function update_size () {
    $order_id = get_sid();
    $cart_item_id = intval($_REQUEST['cart_item_id']);
    $size = $_REQUEST['new_size'];
    $old_size = $_REQUEST['old_size'];
    $type = $_REQUEST['type'];
    $query = "insert into cms2_cart (session_id, size, type, cart_item_id, cart_date, quantity) values ('$order_id', '$size', '$type',  $cart_item_id, $date, $new_quantity)";
    $query = "UPDATE `cms2_cart` SET `size`=  '{$size}' 
                        WHERE  session_id='$order_id'  and cart_item_id = {$cart_item_id} and size =  '{$old_size}'  and type = '$type'";
    $GLOBALS['DB_CONNECTION']->query($query);
    echo 1;
    exit;
  }

  function add_size () {
    $order_id = get_sid();
    $new_quantity = intval($_REQUEST['new_quantity']);
    $cart_item_id = intval($_REQUEST['cart_item_id']);
    $size = $_REQUEST['new_size'];
    $type = $_REQUEST['type'];
    $date = time();
    $query = "insert into cms2_cart (session_id, size, type, cart_item_id, cart_date, quantity) values ('$order_id', '$size', '$type',  $cart_item_id, $date, $new_quantity)";
    $GLOBALS['DB_CONNECTION']->query($query);
    echo 1;
    exit;
  }

  function update_quantity () {
    $order_id = get_sid();
    $new_quantity = intval($_REQUEST['new_quantity']);
    $cart_item_id = intval($_REQUEST['cart_item_id']);
    $new_size = $_REQUEST['new_size'];
    $type = $_REQUEST['type'];
    $query = "UPDATE `cms2_cart` SET `quantity`=  {$new_quantity} 
                        WHERE  session_id='$order_id'  and cart_item_id = {$cart_item_id} and size =  '{$new_size}'  and type = '$type'";
    $GLOBALS['DB_CONNECTION']->query($query);
    echo 1;
    exit;
  }

  function remove_size_from_cart () {
      $order_id = get_sid();
      //$remove_size_from_cart = addslashes($_REQUEST['remove_size_from_cart']);
      $remove_size_from_cart = $_REQUEST['remove_size_from_cart'];
      $cart_item_id = intval($_REQUEST['cart_item_id']);
      $type = $_REQUEST['type'];
      if ($cart_item_id) {
        $query = "delete from cms2_cart where session_id='$order_id' and cart_item_id = '$cart_item_id' and size like '$remove_size_from_cart' and type = '$type'";
        $GLOBALS['DB_CONNECTION']->query($query);  
      }
      echo 1;
      exit;
  }

  function remove_to_cart ()
  {
    $order_id = get_sid();
    $cart_item_id = intval($_REQUEST['cart_item_id']);
    $type = $_REQUEST['type'];
    if ($cart_item_id) {
      $GLOBALS['DB_CONNECTION']->query("delete from cms2_cart where session_id='$order_id' and cart_item_id = '$cart_item_id' and type = '$type'");  
    }
    echo 1;
    exit;
  }
  
  function add_to_cart()
  {
    $order_id = get_sid();
    $date = time();
    $item = intval($_REQUEST['item']);
    $size = $_REQUEST['size'];
    $type = $_REQUEST['type'];
    $quantity = $_REQUEST['quantity'] ? $_REQUEST['quantity'] : 1;
    $r = $GLOBALS['DB_CONNECTION']->query("select cart_id, cart_item_id  from cms2_cart where cart_item_id={$item} and session_id='$order_id' and size = '$size' and type = '$type'");
    if(!($r && $row = $r->fetch_assoc()))
    {
        $query = "insert into cms2_cart (session_id, size, type, cart_item_id, cart_date, quantity) values ('$order_id', '$size', '$type', $item, $date, $quantity)";
        $GLOBALS['DB_CONNECTION']->query($query);
    }
    else
    {
       $query = "UPDATE `cms2_cart` SET `quantity`=  `quantity` + $quantity 
                        WHERE  session_id='$order_id'  and cart_item_id = {$item} and cart_id = {$row['cart_id']} and type = '$type'";
        $GLOBALS['DB_CONNECTION']->query($query);
     }
    return 1;
  }
  function get_cart_without_size(){
     $order_id = get_sid();
     $query = "select cart_id, cart_item_id, quantity, size,
    c.id
    from cms2_cart left join studio_catalog_carslberg as c on cart_item_id = c.id
    where session_id='$order_id'  and type = 'carlsberg' order by c.id";

    $r = $GLOBALS['DB_CONNECTION']->query($query);
    $GLOBALS['IDS'] = array();
    while($r&&$row = $r->fetch_assoc())
    {
       $GLOBALS['IDS'][$row['id']]=1;
    }
  }
  function get_cart()
  {
    $order_id = get_sid();
    $type = $_REQUEST['type'];
    if ($type) {
      $table_catalog ="studio_catalog_carslberg";
      $table_extra_props = "studio_extra_props_carslberg";
    } else {
      $table_catalog = "studio_catalog";
      $table_extra_props = "studio_extra_props";
    }
    
    $query = "select cart_id, cart_item_id, quantity, size,
    c.*, (SELECT p.value from {$table_extra_props} as p where INSTR(concat(',',c.extra_props,','),concat(',',p.id,','))>0 and (p.title like 'Размер' or p.title like 'размер') limit 1) as all_size
    from cms2_cart left join {$table_catalog} as c on cart_item_id = c.id
    where session_id='$order_id'  and type = '{$type}' order by c.id";

    $r = $GLOBALS['DB_CONNECTION']->query($query);
    $GLOBALS['II_CART_ITEMS'] = array();
    while($r&&$row = $r->fetch_assoc())
    {
      if (array_key_exists($row['cart_item_id'], $GLOBALS['II_CART_ITEMS'])===false) {
        if ($row['cart_item_id']) {
         $row['price'] = get_price($row);
         $GLOBALS['II_CART_ITEMS'][$row['cart_item_id']] = array (
                                                              'cart_item_id' => $row['cart_item_id'],
                                                              'article' => $row['article'],
                                                              'title'=>$row['title'], 
                                                              'title_latin'=>$row['title_latin'], 
                                                              'img' => $row['pict'] ? 'http://vostok.spb.ru/images/items/small/'.$row['pict'] : '',
                                                              'size' => explode_trim(',',$row['all_size']),
                                                              'extra_props' => $row['extra_props'],
                                                              'price' => $row['price'],
                                                              'cart_id' =>  array($row['cart_id']),
                                                              'select_size' => array($row['size']),
                                                              'quantity' => array($row['quantity']),
                                                              'common_row_price' => array($row['quantity']*$row['price'])
                                                              );   
        }
      } else {
         $GLOBALS['II_CART_ITEMS'][$row['cart_item_id']] ['select_size'][]=$row['size'];
         $GLOBALS['II_CART_ITEMS'][$row['cart_item_id']] ['quantity'][]=$row['quantity'];
         $GLOBALS['II_CART_ITEMS'][$row['cart_item_id']] ['common_row_price'][]=$row['quantity']*$row['price'];
      }
    }
    echo json_encode(array('basket'=>$GLOBALS['II_CART_ITEMS'],'currency'=>get_type_currency()));
    exit;
  }

  function explode_trim ($delim, $str) {
    $arr = explode ($delim, $str);
    $new_arr = array ();
    foreach ($arr as $v) {
      if ($v) {
        $new_arr[]=trim($v);
      }
      
    }
    return $new_arr;
  }
  function get_sid()
  {
    $date = time();
    $sid = '';

    $GLOBALS['DB_CONNECTION']->query("delete from cms2_session where login_time < ". ( $date - 7*24*60*60));
    
    if (!isset($_SESSION['II_SID'])) 
    {
        $user_uid=md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].$date);
        $GLOBALS['DB_CONNECTION']->query("insert into cms2_session (login_time, ip) values ($date , '{$user_uid}')");
        $_SESSION['II_SID'] = $GLOBALS['DB_CONNECTION']->insert_id;
    }
    return $_SESSION['II_SID'];
  }

?>

