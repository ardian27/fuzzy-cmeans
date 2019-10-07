<html>

<head></head>

<body>

    <?php


    $data = array(
        array(100, 100, 100, 100, 100, 98, 100, 99, 90, 82),
        array(89, 76, 80, 85, 78, 98, 76, 80, 90, 59),
        array(87, 75, 80, 85, 78, 98, 76, 80, 90, 78),
        array(75, 82, 80, 85, 78, 98, 76, 80, 90, 98), 
    );
    $hasilsum=array();
    $dt = array(
        array(1, 1, 1),
        array(1, 2, 4),
        array(3, 3, 3)
    ); 

    foreach ($dt as $key=>$value) {
        
                $hasilsum[$key] = array_sum($value);
        
    }
    print_r($hasilsum);

    


    $w = sizeof($data);
    $h = sizeof($data[0]);
    
    // echo $w;
    // echo $h;

    for ($a = 0; $a < 1; $a++) {
        // echo array_sum($dt[1]);
    }
    $output =  startFCM($data, 5000, 0.00000001);
    // print("<pre>Data Awal " . print_r($data, true) . "</pre>");
    // print("<pre>Partisi Awal " . print_r($partisiawal, true) . "</pre>");

    foreach ($output as $value) {
        // print("<pre>Partisi Awal " . $value. "</pre> ");
        print("<pre> " . print_r($value, true) . "</pre>");
    }


    function startFCM($data, $max_iterasi, $max_error)
    {
        $w = sizeof($data[0]);
        $h = sizeof($data); 

        $partisiawalC1 = getRandom($h);
        $partisiawalC2 = getRandom($h);

        $pusat_cluster1 = pusatCluster($data, $partisiawalC1);
        $pusat_cluster2 = pusatCluster($data, $partisiawalC2);

        $hasilbagi1 = $pusat_cluster1[0];
        $pow_partisi1 = $pusat_cluster1[1];

        $hasilbagi2 = $pusat_cluster2[0];
        $pow_partisi2 = $pusat_cluster2[1];

        $fungsi_objectif = getFungsiObjectif($data, $pow_partisi1, $pow_partisi2, $hasilbagi1, $hasilbagi2);

        // // $new_pusat_cluster1 = array();
        // // $new_pusat_cluster2 = array();
        $new_hasilbagi1 = array();
        $new_hasilbagi2 = array();
        $new_pow_partisi1 = array();
        $new_pow_partisi2 = array();
        $new_fungsi_objectif = array();

        $data_fungsi_objektif = array();
        $partisi_baru1 = array();
        $partisi_baru2 = array();
        $sum_objektif = array();
        $error = array();

        array_push($data_fungsi_objektif, $fungsi_objectif);
        array_push($partisi_baru1, $fungsi_objectif[0]);
        array_push($partisi_baru2, $fungsi_objectif[1]);
        array_push($sum_objektif, $fungsi_objectif[2]);

 
        for ($i = 0; $i < $max_iterasi - 1; $i++) {

            if ($i == 0) {
                $new_pusat_cluster1[$i] = pusatCluster($data, $partisi_baru1[$i]);
                $new_pusat_cluster2[$i] = pusatCluster($data, $partisi_baru2[$i]);

                $new_hasilbagi1[$i] = $new_pusat_cluster1[$i][0];
                $new_hasilbagi2[$i] = $new_pusat_cluster2[$i][0];

                $new_pow_partisi1[$i] = $new_pusat_cluster1[$i][1];
                $new_pow_partisi2[$i] = $new_pusat_cluster2[$i][1];

                $x = getFungsiObjectif($data, $new_pow_partisi1[$i], $new_pow_partisi2[$i], $new_hasilbagi1[$i], $new_hasilbagi2[$i]);


                array_push($partisi_baru1, $x[0]);
                array_push($partisi_baru2, $x[1]);
                array_push($sum_objektif, $x[2]);

            } 
            else if(abs($sum_objektif[$i]-$sum_objektif[$i-1]) <= $max_error)
            {
                break;
            }else
            {
                $new_pusat_cluster1[$i] = pusatCluster($data, $partisi_baru1[$i]);
                $new_pusat_cluster2[$i] = pusatCluster($data, $partisi_baru2[$i]);

                $new_hasilbagi1[$i] = $new_pusat_cluster1[$i][0];
                $new_hasilbagi2[$i] = $new_pusat_cluster2[$i][0];

                $new_pow_partisi1[$i] = $new_pusat_cluster1[$i][1];
                $new_pow_partisi2[$i] = $new_pusat_cluster2[$i][1];

                $x = getFungsiObjectif($data, $new_pow_partisi1[$i], $new_pow_partisi2[$i], $new_hasilbagi1[$i], $new_hasilbagi2[$i]);


                array_push($partisi_baru1, $x[0]);
                array_push($partisi_baru2, $x[1]);
                array_push($sum_objektif, $x[2]);
            }
        }


        return [$partisi_baru1, $partisi_baru2, $sum_objektif];
    }



    function  getRandom($width)
    {
        $datarandom = array();
        for ($a = 0; $a < $width; $a++) {
            $datarandom[$a] =  rand(0, 999) / 999;
        }

        return $datarandom;
    }

    function power_2($data_array,  $height)
    {

        $hasil = array();

        for ($a = 0; $a < $height; $a++) {
            $hasil[$a] = round_4($data_array[$a] * $data_array[$a]);
        }
        return $hasil;
    }

    function pusatCluster($data, $matrik_partisi)
    {
        $w = sizeof($data[0]);
        $h = sizeof($data); 
        $pow_matrik_partisi = power_2($matrik_partisi, $h);

        $hasil = array();
        $hasilsum = array();
        $hasilbagi = array();

        for ($a = 0; $a < $h; $a++) {
            for ($b = 0; $b < $w; $b++) {
                $hasil[$a][$b] = $data[$a][$b]  * $pow_matrik_partisi[$a];
            }
        }
        foreach ($hasil as $value) {
            foreach ($value as $key => $number) {
                (!isset($hasilsum[$key])) ?
                    $hasilsum[$key] = $number : $hasilsum[$key] += $number;
            }
        }
        $sumpartisi = array_sum($pow_matrik_partisi);
        // echo $sumpartisi;
        for ($i = 0; $i < $w; $i++) {
            $hasilbagi[$i] = round_4($hasilsum[$i] / $sumpartisi);
        }
        return
            [
                // $data,
                // $pow_matrik_partisi,
                // $hasil,
                // $hasilsum,
                // $hasilbagi
                $hasilbagi,
                $pow_matrik_partisi
            ]
            // $hasilbagi
        ;
    }

    function getSumPusatCluster($data_array)
    {
        $hasil = array_sum($data_array);
        return $hasil;
    }

    function getFungsiObjectif($data, $matrixpow1, $matrixpow2, $matrikpusatcluster1, $matrikpusatcluster2)
    {
        $w = sizeof($data[0]);
        $h = sizeof($data);
        $hasil = array();
        $new_matrik_partisi1 = $matrixpow1;
        $new_matrik_partisi2 = $matrixpow2;
        $matrik_hasilchildsum1 = getChildFungsiObjectif($data, $matrikpusatcluster1);
        $hasil_sumchild1 = $matrik_hasilchildsum1[1];
        $hasil_sumkalichild1 = $matrik_hasilchildsum1[0];
        $matrik_hasilchildsum2 = getChildFungsiObjectif($data, $matrikpusatcluster2);
        $hasil_sumchild2 = $matrik_hasilchildsum2[1];
        $hasil_sumkalichild2 = $matrik_hasilchildsum2[0];
        $matrik_hasilkalichildsum1 = array();
        $matrik_hasilkalichildsum2 = array();
        $matrik_hasilkalichildsumMin1 = array();
        $matrik_hasilkalichildsumMin1 = array();
        $hasil1 = array();
        $hasil2 = array();
        $partisibaru1 = array();
        $partisibaru2 = array();

        for ($a = 0; $a < $h; $a++) {
            $matrik_hasilkalichildsum1[$a] = ($hasil_sumkalichild1[$a] * $new_matrik_partisi1[$a]);
            $matrik_hasilkalichildsum2[$a] = ($hasil_sumkalichild2[$a] * $new_matrik_partisi2[$a]);

            $matrik_hasilkalichildsumMin1[$a] = pow($hasil_sumkalichild1[$a], -1);
            $matrik_hasilkalichildsumMin2[$a] = pow($hasil_sumkalichild2[$a], -1);
        }

        for ($a = 0; $a < $h; $a++) {
            $hasil1[$a] =  $matrik_hasilkalichildsum1[$a] + $matrik_hasilkalichildsum2[$a];
            $hasil2[$a] = ($matrik_hasilkalichildsumMin1[$a] + $matrik_hasilkalichildsumMin2[$a]);
        }

        for ($a = 0; $a < $h; $a++) {
            $partisibaru1[$a] =  $matrik_hasilkalichildsumMin1[$a] / $hasil2[$a];
            $partisibaru2[$a] =  $matrik_hasilkalichildsumMin2[$a] / $hasil2[$a];
        }



        return
            [
                $partisibaru1,
                $partisibaru2,
                array_sum($hasil1)
            ];
    }

    function getChildFungsiObjectif($data, $matrikpusatcluster)
    {

        $w = sizeof($data[0]);
        $h = sizeof($data); 
        $hasil = array();
        $hasilsum = array();

        for ($a = 0; $a < $h; $a++) {
            for ($b = 0; $b < $w; $b++) {
                $hasil[$a][$b] = round_4(pow(($data[$a][$b] - $matrikpusatcluster[$b]), 2));
            }
        }
        foreach ($hasil as $value) {
            foreach ($value as $key => $number) {
                (!isset($hasilsum[$key])) ?
                    $hasilsum[$key] = $number : $hasilsum[$key] += $number;
            }
        }
        // print_r($matrikpusatcluster);
        // print("<pre> " . print_r($hasilsum , true) . "</pre>");
        // print("<pre> " . print_r($hasil , true) . "</pre>");

        return [$hasilsum, $hasil];
    }

    function getNewPartisiU($data, $matrikpartisi1, $matrikpartisi2, $matrikpusatcluster1, $matrikpusatcluster2)
    {
        $w = sizeof($data);
        $h = sizeof($data[0]);
        $hasil = array();
        $new_matrik_partisi1 = power_2($matrikpartisi1, $w, $h);
        $new_matrik_partisi2 = power_2($matrikpartisi2, $w, $h);
        $matrik_hasilchildpartisiUsum1 = getChildPartisiU($data, $new_matrik_partisi1);
        $matrik_hasilchildpartisiUsum2 = getChildPartisiU($data, $new_matrik_partisi2);
        $matrik_hasilkalichildsum1 = array();
        $matrik_hasilkalichildsum2 = array();
        $hasil_sum = array();
        $hasil1 = array();
        $hasil2 = array();

        for ($a = 0; $a < $h; $a++) {
            $matrik_hasilkalichildsum1[$a] = pow(($matrik_hasilchildpartisiUsum1[$a] * $matrikpusatcluster1[$a]), -1);
            $matrik_hasilkalichildsum2[$a] = pow(($matrik_hasilchildpartisiUsum2[$a] * $matrikpusatcluster2[$a]), -1);
        }

        for ($a = 0; $a < $h; $a++) {
            $hasil_sum[$a] = $matrik_hasilchildpartisiUsum1[$a] + $matrik_hasilchildpartisiUsum2[$a];
        }

        for ($a = 0; $a < $h; $a++) {
            $hasil1 = $matrik_hasilkalichildsum1[$a] / $hasil_sum[$a];
            $hasil2 = $matrik_hasilkalichildsum1[$a] / $hasil_sum[$a];
        }




        return [$hasil1, $hasil2];
    }


    function getChildPartisiU($data, $matrikpusatcluster)
    {
        $w = sizeof($data);
        $h = sizeof($data[0]);
        $hasil = array();
        $hasilsum = array();

        for ($a = 0; $a < $w; $a++) {
            for ($b = 0; $b < $h; $b++) {
                $hasil[$a] = pow($data[$a][$b] - $matrikpusatcluster[$b], 2);
            }
            $hasilsum = array_sum($hasil[$a]);
        }
        return $hasilsum;
    }

    function round_4($nilai)
    {
        return round($nilai, 4);
    }

    function round_6($nilai)
    {
        return round($nilai, 6);
    }

    ?>

</body>

</html>