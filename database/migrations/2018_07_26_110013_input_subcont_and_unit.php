<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InputSubcontAndUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('subconts')->truncate();
        DB::table('subcont_units')->truncate();

        $subcont = App\Subcont::create(['name' => 'PT. FJT']);
        $units = [
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H300','empty_weight'=>'13860','average_weight'=>'29550'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H301','empty_weight'=>'13930','average_weight'=>'30210'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H302','empty_weight'=>'13840','average_weight'=>'29760'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H303','empty_weight'=>'13990','average_weight'=>'30080'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H304','empty_weight'=>'14290','average_weight'=>'30520'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H305','empty_weight'=>'13720','average_weight'=>'29940'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H306','empty_weight'=>'14060','average_weight'=>'29950'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H307','empty_weight'=>'14240','average_weight'=>'30200'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H308','empty_weight'=>'14840','average_weight'=>'29390'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H309','empty_weight'=>'13950','average_weight'=>'29720'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H310','empty_weight'=>'13060','average_weight'=>'27450'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H311','empty_weight'=>'12890','average_weight'=>'29260'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H312','empty_weight'=>'13120','average_weight'=>'29280'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H313','empty_weight'=>'13210','average_weight'=>'28920'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H314','empty_weight'=>'12950','average_weight'=>'28940'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H315','empty_weight'=>'13010','average_weight'=>'28390'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H316','empty_weight'=>'12600','average_weight'=>'28970'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H317','empty_weight'=>'13090','average_weight'=>'29040'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H318','empty_weight'=>'14380','average_weight'=>'30250'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H319','empty_weight'=>'13280','average_weight'=>'28860'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H320','empty_weight'=>'12470','average_weight'=>'27780'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H321','empty_weight'=>'14200','average_weight'=>'30130'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H322','empty_weight'=>'13920','average_weight'=>'30330'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H323','empty_weight'=>'12870','average_weight'=>'28500'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H324','empty_weight'=>'14230','average_weight'=>'29290'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H325','empty_weight'=>'13200','average_weight'=>'28190'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H326','empty_weight'=>'14180','average_weight'=>'29030'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H327','empty_weight'=>'13750','average_weight'=>'28550'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H328','empty_weight'=>'14700','average_weight'=>'29740'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H329','empty_weight'=>'14340','average_weight'=>'30090'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H330','empty_weight'=>'14230','average_weight'=>'29500'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H331','empty_weight'=>'14220','average_weight'=>'26930'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H332','empty_weight'=>'13310','average_weight'=>'27150'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H333','empty_weight'=>'13730','average_weight'=>'29440'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H334','empty_weight'=>'13340','average_weight'=>'28320'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H335','empty_weight'=>'13190','average_weight'=>'27700'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H336','empty_weight'=>'14590','average_weight'=>'28810'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H337','empty_weight'=>'14720','average_weight'=>'30590'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H338','empty_weight'=>'14370','average_weight'=>'29200'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H339','empty_weight'=>'13900','average_weight'=>'30330'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H340','empty_weight'=>'12960','average_weight'=>'25570'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H341','empty_weight'=>'14090','average_weight'=>'29030'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H342','empty_weight'=>'13800','average_weight'=>'28020'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H343','empty_weight'=>'14650','average_weight'=>'30190'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H344','empty_weight'=>'12480','average_weight'=>'28790'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H345','empty_weight'=>'13240','average_weight'=>'30040'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H346','empty_weight'=>'12420','average_weight'=>'28310'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H347','empty_weight'=>'14890','average_weight'=>'29080'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H348','empty_weight'=>'12660','average_weight'=>'27150'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H349','empty_weight'=>'12520','average_weight'=>'27190'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H350','empty_weight'=>'13360','average_weight'=>'30420'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H351','empty_weight'=>'14560','average_weight'=>'28800'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H352','empty_weight'=>'14670','average_weight'=>'29080'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H353','empty_weight'=>'13650','average_weight'=>'28150'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H354','empty_weight'=>'14200','average_weight'=>'27720'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H355','empty_weight'=>'12460','average_weight'=>'24860'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H356','empty_weight'=>'12050','average_weight'=>'25190'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H357','empty_weight'=>'14330','average_weight'=>'30640'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H358','empty_weight'=>'14550','average_weight'=>'29590'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H359','empty_weight'=>'14340','average_weight'=>'30190'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H360','empty_weight'=>'14030','average_weight'=>'29430'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H361','empty_weight'=>'14300','average_weight'=>'30050'],
            ['type'=>'HINO','model'=>'FM260','code_number'=>'H362','empty_weight'=>'14500','average_weight'=>'29490']
        ];
        $subcont->subcontUnits()->createMany($units);

        $subcont = App\Subcont::create(['name' => 'PT. HA']);
        $units = [
            ['type'=>'rino','model'=>'FM260','code_number'=>'H200','empty_weight'=>'12990 ','average_weight'=>'25910 '],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H201','empty_weight'=>'12570 ','average_weight'=>'25870 '],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H202','empty_weight'=>'12810 ','average_weight'=>'27570 '],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H203','empty_weight'=>'12660 ','average_weight'=>'25140 '],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H204','empty_weight'=>'12840 ','average_weight'=>'25950 '],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H205','empty_weight'=>'12420 ','average_weight'=>'25880 '],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H206','empty_weight'=>'12790 ','average_weight'=>'26830 '],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H207','empty_weight'=>'12990 ','average_weight'=>'25110 '],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H208','empty_weight'=>'12750 ','average_weight'=>'26110 '],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H209','empty_weight'=>'12810 ','average_weight'=>'25390 '],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H210','empty_weight'=>'12690 ','average_weight'=>'25860 '],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H211','empty_weight'=>'12820 ','average_weight'=>'26000 '],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H212','empty_weight'=>'12850 ','average_weight'=>'26130'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H213','empty_weight'=>'13080 ','average_weight'=>'26650'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H214','empty_weight'=>'13030 ','average_weight'=>'26560'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H215','empty_weight'=>'12800 ','average_weight'=>'26170'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H216','empty_weight'=>'13660 ','average_weight'=>'26120'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H217','empty_weight'=>'13830 ','average_weight'=>'25840'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H218','empty_weight'=>'12680 ','average_weight'=>'25930'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H219','empty_weight'=>'13510 ','average_weight'=>'26050'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H220','empty_weight'=>'12660 ','average_weight'=>'26060'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H221','empty_weight'=>'12850 ','average_weight'=>'26030'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H222','empty_weight'=>'12660 ','average_weight'=>'26280'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H223','empty_weight'=>'12820 ','average_weight'=>'25760'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H224','empty_weight'=>'12850 ','average_weight'=>'25130'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H225','empty_weight'=>'13490 ','average_weight'=>'26030'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H226','empty_weight'=>'12730 ','average_weight'=>'26200'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H227','empty_weight'=>'12930 ','average_weight'=>'26580'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H228','empty_weight'=>'13410 ','average_weight'=>'26990'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H229','empty_weight'=>'12870 ','average_weight'=>'26610'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H230','empty_weight'=>'12820 ','average_weight'=>'26470'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H231','empty_weight'=>'12700 ','average_weight'=>'26010'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H232','empty_weight'=>'12780 ','average_weight'=>'26180'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H233','empty_weight'=>'14720 ','average_weight'=>'26420'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H234','empty_weight'=>'14350 ','average_weight'=>'26470'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H235','empty_weight'=>'14290 ','average_weight'=>'26520'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H236','empty_weight'=>'14350 ','average_weight'=>'25900'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H237','empty_weight'=>'14310 ','average_weight'=>'26380'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H238','empty_weight'=>'14370 ','average_weight'=>'26410'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H239','empty_weight'=>'14390 ','average_weight'=>'26530'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H240','empty_weight'=>'14420 ','average_weight'=>'0'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H241','empty_weight'=>'14360 ','average_weight'=>'0'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H242','empty_weight'=>'14390 ','average_weight'=>'0'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H243','empty_weight'=>'14550 ','average_weight'=>'0'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H244','empty_weight'=>'14380 ','average_weight'=>'0']
        ];
        $subcont->subcontUnits()->createMany($units);

        $subcont = App\Subcont::create(['name' => 'PT. PKU']);
        $units = [
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H100','empty_weight'=>'13970','average_weight'=>'30650'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H101','empty_weight'=>'14470','average_weight'=>'28450'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H102','empty_weight'=>'14180','average_weight'=>'29710'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H103','empty_weight'=>'13830','average_weight'=>'28170'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H104','empty_weight'=>'14400','average_weight'=>'29920'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H105','empty_weight'=>'13840','average_weight'=>'30490'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H106','empty_weight'=>'13640','average_weight'=>'28390'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H107','empty_weight'=>'12870','average_weight'=>'27590'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H108','empty_weight'=>'13630','average_weight'=>'28470'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H109','empty_weight'=>'14330','average_weight'=>'28260'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H110','empty_weight'=>'13690','average_weight'=>'27040'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H111','empty_weight'=>'14560','average_weight'=>'28690'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H112','empty_weight'=>'14340','average_weight'=>'27050'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H113','empty_weight'=>'14820','average_weight'=>'29010'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H114','empty_weight'=>'13250','average_weight'=>'27900'],
            ['type'=>'Hino','model'=>'FM320','code_number'=>'H115','empty_weight'=>'14180','average_weight'=>'28830'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H116','empty_weight'=>'14640','average_weight'=>'29040'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H117','empty_weight'=>'14020','average_weight'=>'31340'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H118','empty_weight'=>'13840','average_weight'=>'27640'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H119','empty_weight'=>'13360','average_weight'=>'27600'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H122','empty_weight'=>'14420','average_weight'=>'27280'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H120','empty_weight'=>'13280','average_weight'=>'25650'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H121','empty_weight'=>'14320','average_weight'=>'27690'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H123','empty_weight'=>'13600','average_weight'=>'26440'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H124','empty_weight'=>'14420','average_weight'=>'30190'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H125','empty_weight'=>'14130','average_weight'=>'31310'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H126','empty_weight'=>'12540','average_weight'=>'25720'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H127','empty_weight'=>'14080','average_weight'=>'28120'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H128','empty_weight'=>'14530','average_weight'=>'29120'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H129','empty_weight'=>'13600','average_weight'=>'28770'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H130','empty_weight'=>'12960','average_weight'=>'28120'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H131','empty_weight'=>'13620','average_weight'=>'26290'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H132','empty_weight'=>'12830','average_weight'=>'27240'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H133','empty_weight'=>'13790','average_weight'=>'28310'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H134','empty_weight'=>'13840','average_weight'=>'27710'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H135','empty_weight'=>'14560','average_weight'=>'30190'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H136','empty_weight'=>'12860','average_weight'=>'26350'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H137','empty_weight'=>'13990','average_weight'=>'32320'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H138','empty_weight'=>'13390','average_weight'=>'29530'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H139','empty_weight'=>'13490','average_weight'=>'28810'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H140','empty_weight'=>'14160','average_weight'=>'27990'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H141','empty_weight'=>'14190','average_weight'=>'29800'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H142','empty_weight'=>'13750','average_weight'=>'29540'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H143','empty_weight'=>'12410','average_weight'=>'25530'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H144','empty_weight'=>'12680','average_weight'=>'28570'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H145','empty_weight'=>'14180','average_weight'=>'28810'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H146','empty_weight'=>'13020','average_weight'=>'28160'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H147','empty_weight'=>'14170','average_weight'=>'31580'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H148','empty_weight'=>'14070','average_weight'=>'30790'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H149','empty_weight'=>'14050','average_weight'=>'27740'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H150','empty_weight'=>'12840','average_weight'=>'26640'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H151','empty_weight'=>'14280','average_weight'=>'28260'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H152','empty_weight'=>'14330','average_weight'=>'27840'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H153','empty_weight'=>'14580','average_weight'=>'28220'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H154','empty_weight'=>'14470','average_weight'=>'28800'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H155','empty_weight'=>'12790','average_weight'=>'26480'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H156','empty_weight'=>'13050','average_weight'=>'26450'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H157','empty_weight'=>'14480','average_weight'=>'28520'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H158','empty_weight'=>'14230','average_weight'=>'27950'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H159','empty_weight'=>'14460','average_weight'=>'29600'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H160','empty_weight'=>'14220','average_weight'=>'30090']
        ];
        $subcont->subcontUnits()->createMany($units);

        $subcont = App\Subcont::create(['name' => 'PT. HSR']);
        $units = [
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H500','empty_weight'=>'12190','average_weight'=>'24470'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H501','empty_weight'=>'11460','average_weight'=>'22970'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H502','empty_weight'=>'11840','average_weight'=>'23190'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H503','empty_weight'=>'11460','average_weight'=>'22760'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H504','empty_weight'=>'12160','average_weight'=>'23190'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H505','empty_weight'=>'12390','average_weight'=>'24480'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H506','empty_weight'=>'12200','average_weight'=>'24640'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H507','empty_weight'=>'13880','average_weight'=>'28200'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H508','empty_weight'=>'13590','average_weight'=>'28330'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H509','empty_weight'=>'13550','average_weight'=>'27680'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H510','empty_weight'=>'11370','average_weight'=>'22200'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H511','empty_weight'=>'14090','average_weight'=>'28010'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H512','empty_weight'=>'13690','average_weight'=>'28090'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H513','empty_weight'=>'12380','average_weight'=>'27220'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H514','empty_weight'=>'14010','average_weight'=>'27110'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H515','empty_weight'=>'14080','average_weight'=>'27500'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H516','empty_weight'=>'14020','average_weight'=>'26080']
        ];
        $subcont->subcontUnits()->createMany($units);

        $subcont = App\Subcont::create(['name' => 'PT. HAM']);
        $units = [
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H400','empty_weight'=>'14260','average_weight'=>'30610'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H401','empty_weight'=>'15070','average_weight'=>'31100'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H402','empty_weight'=>'14300','average_weight'=>'29690'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H403','empty_weight'=>'13740','average_weight'=>'29430'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H404','empty_weight'=>'12550','average_weight'=>'29970'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H405','empty_weight'=>'13850','average_weight'=>'29840'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H406','empty_weight'=>'14010','average_weight'=>'29550'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H407','empty_weight'=>'13960','average_weight'=>'29720'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H408','empty_weight'=>'14000','average_weight'=>'30750'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H409','empty_weight'=>'14230','average_weight'=>'29850'],
            ['type'=>'Hino','model'=>'FM320','code_number'=>'H410','empty_weight'=>'14400','average_weight'=>'29760'],
            ['type'=>'Hino','model'=>'FM320','code_number'=>'H411','empty_weight'=>'13430','average_weight'=>'29220'],
            ['type'=>'Hino','model'=>'FM320','code_number'=>'H412','empty_weight'=>'13950','average_weight'=>'31720'],
            ['type'=>'Hino','model'=>'FM320','code_number'=>'H413','empty_weight'=>'13140','average_weight'=>'28670'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H414','empty_weight'=>'12880','average_weight'=>'26490'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H415','empty_weight'=>'14130','average_weight'=>'30230'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H416','empty_weight'=>'12360','average_weight'=>'27490'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H417','empty_weight'=>'13280','average_weight'=>'30040'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H419','empty_weight'=>'13270','average_weight'=>'26660'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H420','empty_weight'=>'13010','average_weight'=>'25930'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H421','empty_weight'=>'14290','average_weight'=>'29930'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H422','empty_weight'=>'14640','average_weight'=>'28750'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H423','empty_weight'=>'13730','average_weight'=>'27040'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H424','empty_weight'=>'14760','average_weight'=>'30530'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H425','empty_weight'=>'14230','average_weight'=>'28410'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H426','empty_weight'=>'13720','average_weight'=>'25620'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H427','empty_weight'=>'12830','average_weight'=>'27290'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H428','empty_weight'=>'14120','average_weight'=>'30040']
        ];
        $subcont->subcontUnits()->createMany($units);

        $subcont = App\Subcont::create(['name' => 'PT. BEM']);
        $units = [
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H800','empty_weight'=>'12900','average_weight'=>'28710'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H801','empty_weight'=>'13620','average_weight'=>'29650'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H802','empty_weight'=>'13430','average_weight'=>'29300'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H803','empty_weight'=>'12270','average_weight'=>'25970'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H804','empty_weight'=>'12930','average_weight'=>'28490'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H805','empty_weight'=>'12240','average_weight'=>'27890'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H806','empty_weight'=>'12530','average_weight'=>'29180'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H807','empty_weight'=>'12800','average_weight'=>'29100'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H808','empty_weight'=>'12830','average_weight'=>'29000'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H809','empty_weight'=>'12400','average_weight'=>'25460'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H810','empty_weight'=>'12800','average_weight'=>'29110'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H811','empty_weight'=>'12630','average_weight'=>'29290'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H812','empty_weight'=>'12210','average_weight'=>'25560'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H813','empty_weight'=>'13050','average_weight'=>'29090'],
        ];
        $subcont->subcontUnits()->createMany($units);

        $subcont = App\Subcont::create(['name' => 'PT. BKB']);
        $units = [
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H901','empty_weight'=>'12760','average_weight'=>'24950'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H902','empty_weight'=>'12820','average_weight'=>'25910'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H903','empty_weight'=>'14120','average_weight'=>'31570'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H904','empty_weight'=>'13430','average_weight'=>'29280'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H905','empty_weight'=>'13380','average_weight'=>'31370'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H906','empty_weight'=>'14520','average_weight'=>'28230'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H907','empty_weight'=>'14530','average_weight'=>'28170'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H908','empty_weight'=>'12660','average_weight'=>'26960'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H909','empty_weight'=>'12830','average_weight'=>'27840'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H910','empty_weight'=>'14160','average_weight'=>'0']
        ];
        $subcont->subcontUnits()->createMany($units);

        $subcont = App\Subcont::create(['name' => 'PT. PPMJ']);
        $units = [
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H700','empty_weight'=>'13790','average_weight'=>'30280'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H701','empty_weight'=>'13780','average_weight'=>'30670'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H703','empty_weight'=>'13760','average_weight'=>'31730'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'H704','empty_weight'=>'13850','average_weight'=>'29300']
        ];
        $subcont->subcontUnits()->createMany($units);

        $subcont = App\Subcont::create(['name' => 'PT. SSP']);
        $units = [
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP01','empty_weight'=>'14750','average_weight'=>'26690'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP02','empty_weight'=>'16640','average_weight'=>'26970'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP023','empty_weight'=>'13070','average_weight'=>'27940'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP024','empty_weight'=>'13460','average_weight'=>'27510'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP025','empty_weight'=>'12730','average_weight'=>'28730'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP026','empty_weight'=>'13170','average_weight'=>'27750'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP027','empty_weight'=>'13130','average_weight'=>'27430'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP028','empty_weight'=>'13480','average_weight'=>'27540'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP029','empty_weight'=>'13090','average_weight'=>'27760'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP03','empty_weight'=>'14890','average_weight'=>'26930'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP04','empty_weight'=>'14370','average_weight'=>'26820'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP05','empty_weight'=>'14350','average_weight'=>'26610'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP410','empty_weight'=>'12690','average_weight'=>'25260'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP438','empty_weight'=>'13270','average_weight'=>'20210'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP445','empty_weight'=>'13030','average_weight'=>'24990'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP447','empty_weight'=>'13050','average_weight'=>'24410'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP449','empty_weight'=>'12680','average_weight'=>'24040'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP450','empty_weight'=>'12810','average_weight'=>'24660'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP451','empty_weight'=>'12680','average_weight'=>'24900'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP452','empty_weight'=>'12630','average_weight'=>'24430'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP453','empty_weight'=>'12780','average_weight'=>'25030'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP454','empty_weight'=>'13630','average_weight'=>'26000'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP455','empty_weight'=>'13030','average_weight'=>'25900'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP456','empty_weight'=>'12610','average_weight'=>'26220'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP457','empty_weight'=>'13590','average_weight'=>'26090'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP458','empty_weight'=>'13570','average_weight'=>'26250'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP459','empty_weight'=>'14740','average_weight'=>'26050'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP460','empty_weight'=>'12650','average_weight'=>'26230'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP461','empty_weight'=>'13500','average_weight'=>'25840'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP462','empty_weight'=>'13110','average_weight'=>'25040'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP463','empty_weight'=>'12770','average_weight'=>'25140'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP464','empty_weight'=>'13170','average_weight'=>'25300'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP465','empty_weight'=>'13280','average_weight'=>'24970'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP466','empty_weight'=>'13240','average_weight'=>'24860'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'SSP467','empty_weight'=>'13250','average_weight'=>'24950']
        ];
        $subcont->subcontUnits()->createMany($units);

        $subcont = App\Subcont::create(['name' => 'PT. RA']);
        $units = [
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA700','empty_weight'=>'12070','average_weight'=>'24050'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA701','empty_weight'=>'12110','average_weight'=>'26740'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA702','empty_weight'=>'12980','average_weight'=>'23400'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA703','empty_weight'=>'12050','average_weight'=>'24530'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA704','empty_weight'=>'12240','average_weight'=>'27360'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA705','empty_weight'=>'11330','average_weight'=>'24530'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA706','empty_weight'=>'13320','average_weight'=>'24780'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA707','empty_weight'=>'12100','average_weight'=>'24050'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA708','empty_weight'=>'12160','average_weight'=>'24420'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA709','empty_weight'=>'11900','average_weight'=>'25790'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA710','empty_weight'=>'13310','average_weight'=>'24410'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA711','empty_weight'=>'12590','average_weight'=>'23300'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA712','empty_weight'=>'12170','average_weight'=>'24130'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA714','empty_weight'=>'12860','average_weight'=>'27780'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA715','empty_weight'=>'12870','average_weight'=>'27500'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA716','empty_weight'=>'12790','average_weight'=>'26420'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA717','empty_weight'=>'12030','average_weight'=>'27310'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA718','empty_weight'=>'13150','average_weight'=>'29820'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA719','empty_weight'=>'13130','average_weight'=>'29630'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA720','empty_weight'=>'13170','average_weight'=>'30150'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA721','empty_weight'=>'13100','average_weight'=>'30100'],
            ['type'=>'Hino','model'=>'FM260','code_number'=>'RA722','empty_weight'=>'13250','average_weight'=>'29710']
        ];
        $subcont->subcontUnits()->createMany($units);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('subconts')->truncate();
        DB::table('subcont_units')->truncate();
    }
}
