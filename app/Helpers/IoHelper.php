<?php

function formula_sektor()
{
    return [
        'Komputer' => ['Ngoding', 'Desain', 'Game'],
        'Otomotif' => ['Mekanik', 'Balap', 'Modifikasi'],
        'Elektro' => ['Elektronika', 'Eksperimen', 'Robot'],
        'Administrasi' => ['Organisasi', 'Analisis Data', 'Bahasa'],
        'Garmen' => ['Desain', 'Jahit', 'Fashion'],
        'Pertanian' => ['Berkebun', 'Eksperimen', 'Kuliner'],
        'Perkebunan' => ['Berkebun', 'Bonsai', 'Tanaman Hias'],
        'Kesehatan' => ['Olahraga', 'Yoga'],
        'Pendidikan' => ['Organisasi', 'Membaca'],
        'Keuangan' => ['Investasi', 'Atur Uang'],
        'Pariwisata' => ['Jalan-jalan', 'Jelajah Alam', 'Fotografi', 'Membaca'],
        'Kuliner' => ['Masak', 'Membuat Kue'],
        'Konstruksi' => ['Olahraga', 'Buat Model Bangunan', 'Konstruksi'],
        'Perikanan' => ['Mancing', 'Budidaya Ikan'],
        'Telekomunikasi' => ['Radio Amatir', 'Jaringan Komputer', 'Sosial Media'],
        'Desain Grafis' => ['Desain Gambar', 'Menggambar', 'Ilustrasi'],
        'Keamanan' => ['Bela Diri', 'Olah Raga']
    ];
}

function hobi_tags()
{
    $data = formula_sektor();
    $result = [];
    foreach ($data as $item) foreach ($item as $item2) $result[] = $item2;
    return $result;
}

function list_jenis()
{
    $jenis = ['Text', 'Pilihan', 'Multiple Pilihan', 'Angka'];
    return array_combine($jenis, $jenis);
}

function list_faktor()
{
    return ['Faktor Ekonomi', 'Faktor Sosial', 'Faktor Pekerjaan Orang Tua', 'Lainnya'];
}

function jenis_formal()
{
    return [1 => 'Formal', 0 => 'Non Formal'];
}

function jenis_sekolah()
{
    $jenis = ['SWASTA', 'NEGERI'];
    return array_combine($jenis, $jenis);
}

function replace_paramster($string)
{
    return preg_replace('/\${[^}]*}/', '...', $string);
}

function keterangan_evaluasi($jenis)
{
    $data = ['Lulus ' . $jenis, 'Tidak Lulus ' . $jenis];
    return array_combine($data, $data);
}



//=========

function curl_request($url, $method = "GET", $fields = '', $header = [])
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $fields,
        CURLOPT_HTTPHEADER => $header,
    ));

    $response = curl_exec($curl);
    $response = json_decode($response, true);

    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
        dd($error_msg);
    }

    curl_close($curl);
    return $response;
}

function increment_workday($start, $daysToIncrement, array $holidays = [])
{
    $date = \Carbon\Carbon::parse($start);
    $currentDate = $date->copy();
    $incrementedDate = $currentDate->copy();
    while ($daysToIncrement > 0) {
        $incrementedDate->addDay();
        if ($incrementedDate->isWeekend() || in_array($incrementedDate->toDateString(), $holidays)) continue;

        $daysToIncrement--;
    }

    return $incrementedDate->toDateString();
}

function has_route($route, $params = [])
{
    return (\Illuminate\Support\Facades\Route::has($route)) ? route($route, $params) : '#';
}

function paginate_options()
{
    $result = [];
    foreach ([10, 20, 50, 100] as $value) $result[$value] = $value;
    return $result;
}

function gender()
{
    return ['L' => 'Laki-laki', 'P' => 'Perempuan'];
}

function religion()
{
    return [
        'Islam' => 'Islam',
        'Katolik' => 'Katolik',
        'Kristen' => 'Kristen',
        'Hindu' => 'Hindu',
        'Budha' => 'Budha',
        'Konghucu' => 'Konghucu',
        'Lainnya' => 'Lainnya',
    ];
}

function str_limit($value, $limit = 60)
{
    return \Illuminate\Support\Str::limit($value, $limit);
}

function str_slug($value, $separator = '-')
{
    return \Illuminate\Support\Str::slug($value, $separator);
}

function str_unslug($value, $separator = '-')
{
    return ucwords(strtolower(str_replace($separator, ' ', $value)));
}

function str_plural($value, $count = 1)
{
    if ($count === 0) $count = 1;
    return \Illuminate\Support\Str::plural($value, $count);
}

function remove_space($value)
{
    return str_replace(' ', '', $value);
}

function serialize_array($data)
{
    return http_build_query($data);
}

function format_number($number, $currency = 'IDR')
{
    return $number ? ($currency == 'IDR' ? number_format($number, 0, ',', '.') : number_format($number, 2, '.', ',')) : '0';
}

function format_decimal($number)
{
    return $number ? number_format($number, 2, ',', '.') : '';
}


function list_bulan($short = false)
{
    return $short ?
        array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des') :
        array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
}

function list_hari()
{
    return array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
}

function fulldate($date, $divider = "", $shortMonth = false)
{
    if ($date == "") return "";

    $dayText = list_hari();
    $monthText = list_bulan($shortMonth);

    $dayInt = date('N', strtotime($date));
    $date = explode("-", date('Y-m-d', strtotime($date)));
    $monthInt = (int)$date[1];

    $result = [];
    if ($divider !== "") {
        $result[] = $dayText[$dayInt - 1] . ', ';
    }
    $result[] = $date[2];
    $result[] = ' ';
    $result[] = $monthText[$monthInt - 1];
    $result[] = ' ';
    $result[] = $date[0];

    return implode($divider, $result);
}


function format_date($date, $divider = "-")
{
    return $date ? implode($divider, array_reverse(explode("-", date('Y-m-d', strtotime($date))))) : '';
}

function format_time($time, $short = true)
{
    return $time ? ($short ? date('H:i', strtotime($time)) : date('H:i:s', strtotime($time))) : '';
}

function number_to_alphabeth($number)
{
    return chr(64 + $number);
}

function number_to_roman($number)
{
    $map = [
        'M' => 1000, 'CM' => 900,
        'D' => 500, 'CD' => 400,
        'C' => 100, 'XC' => 90,
        'L' => 50, 'XL' => 40,
        'X' => 10, 'IX' => 9,
        'V' => 5, 'IV' => 4,
        'I' => 1,
    ];

    $result = '';
    foreach ($map as $roman => $int) {
        while ($number >= $int) {
            $result .= $roman;
            $number -= $int;
        }
    }
    return $result;
}


function roman_to_number($roman)
{
    $romans = [
        'M' => 1000, 'CM' => 900,
        'D' => 500, 'CD' => 400,
        'C' => 100, 'XC' => 90,
        'L' => 50, 'XL' => 40,
        'X' => 10, 'IX' => 9,
        'V' => 5, 'IV' => 4,
        'I' => 1,
    ];

    $result = 0;
    foreach ($romans as $key => $value) {
        while (strpos($roman, $key) === 0) {
            $result += $value;
            $roman = substr($roman, strlen($key));
        }
    }
    return $result;
}


function spell_number_core($nilai) {
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    if ($nilai < 12) return $huruf[$nilai];
    elseif ($nilai < 20) return spell_number_core($nilai - 10) . " belas";
    elseif ($nilai < 100) return spell_number_core($nilai / 10) . " puluh " . spell_number_core($nilai % 10);
    elseif ($nilai < 1000) return spell_number_core($nilai / 100) . " ratus " . spell_number_core($nilai % 100);
    elseif ($nilai < 1000000) return spell_number_core($nilai / 1000) . " ribu " . spell_number_core($nilai % 1000);
    elseif ($nilai < 1000000000) return spell_number_core($nilai / 1000000) . " juta " . spell_number_core($nilai % 1000000);
    elseif ($nilai < 1000000000000) return spell_number_core($nilai / 1000000000) . " milyar " . spell_number_core(fmod($nilai, 1000000000));
    elseif ($nilai < 1000000000000000) return spell_number_core($nilai / 1000000000000) . " trilyun " . spell_number_core(fmod($nilai, 1000000000000));
    return "";
}

function spell_number($number) {
    if ($number == '') return "";
    if ($number == 0) return "nol";
    elseif ($number < 0) return "minus " . spell_number_core(abs($number));
    else return trim(spell_number_core($number)) . ' rupiah';
}

function date_difference($date1, $date2)
{
    return (new DateTime($date2))->diff(new DateTime($date1))->days + 1;
}

function unformat_date($date)
{
    return $date ? date('Y-m-d', strtotime($date)) : null;
}

function unformat_number($number)
{
    if ($number == '') return $number;
    $number = str_replace('.', '', $number);
    $number = str_replace(',', '.', $number);
    return $number;
}

function random_color() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}
