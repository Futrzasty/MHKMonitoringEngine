<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>IT Helper WEB-APP</title>
    <style type="text/css">
        body {
            color: white;
            background-color: #303030;
            font-family: Helvetica, sans-serif;
        }

        a:link {
            text-decoration: none;
            color: skyblue;
        }

        a:visited {
            text-decoration: none;
            color: skyblue;
        }

        a:hover {
            text-decoration: underline;
            color: skyblue;
        }

        a:active {
            text-decoration: none;
            color: skyblue;
        }
        fieldset {
            border: none;
            margin: 0;
            padding: 0;
        }
        p {
            margin: 0;
            padding: 0;
        }
    </style>
    <script type="text/javascript" src="../../lib/jquery.js"></script>

</head>
<body>
    <p>
    <a href="http://nasze-sprawy.mhk.local">Nasze sprawy</a><br/>
    <br/>
    <a href="https://sbe.mhk.local:9443/vsphere-client/#">vCenter MHK</a><br/>
    <br/>

    <span class="fold_iksoris">iKsoris</span>
    </p>
    <div class="iksoris">
        <a href="http://kasa.mhk.org.pl/">iKsoris - oddziały</a><br/>
        <a href="http://bilety.mhk.pl/administrator/index/logowanie.html">iKsoris - oddziały CMS</a><br/>
        <a href="http://kasa-rynek.mhk.org.pl/">iKsoris - Podziemia </a><br/>
        <a href="http://www.bilety.podziemiarynku.com/administrator/index/logowanie.html">iKsoris - Podziemia CMS</a><br/>
    </div>
    <p>
    <br/>
    <a href="">Cacti MHK</a><br/>
    <a href="">Cacti Fabryka</a><br/>
    <a href="">Cacti Podziemia</a><br/>
    <br/>
    <a href="http://nagios.mhk.local/nagios3">Nagios</a><br/>
    <a href="">Zabbix</a><br/>
    <br/>
    NAS<br/>
        <a href="">qnap-linux</a><br/>
        <a href="">nas-qnap1</a><br/>
        <a href="">nas-siec</a><br/>
        <a href="">qnap2</a><br/>
        <a href="">qnap-plast</a><br/>
        <a href="">qnap-foto</a><br/>
        <a href="">qnap-nhuta</a><br/>
        <a href="">nas-digi</a><br/>
        <a href="">nas-digi1r</a><br/>
        <a href="">nas-backup</a><br/>
        <a href="">qnap-backup</a><br/>
        <a href="">nas-hipolici</a><br/>
        <a href="">nas-rp</a><br/>
        <a href="">nas5</a><br/>
        <a href="http://192.168.14.158">nas-apteka</a><br/>
    <br/>
    UPS<br/>
        <a href="http://192.168.83.66">Jagiellońska Serwerownia</a><br/>
        <a href="http://192.168.83.68">Jagiellońska Piwnica</a><br/>
        <a href="http://192.168.201.6">Jagiellońska Serwerownia - UPS IBM</a><br/>
        <a href="http://192.168.12.210">Podziemia - UPS 1kVA w stacji trafo</a><br/>
        <a href="http://192.168.12.211">Podziemia - UPS 80kVA rozdzielnia -2</a><br/>
        <a href="http://192.168.12.209">Podziemia - UPS 10kVA serwerownia +1</a><br/>
        <a href="http://172.16.0.200">Fabryka Serwerownia</a><br/>
        <a href="http://192.168.16.9">CIA Serwerownia</a><br/>
    <br/>
    Udziały sieciowe:<br/>
    <a href="file://///kms.mhk.local/kp_s$">KeePass Serwis</a><br/>

    <br/>
    MPRL-u:<br/>
        <a href="https://vcenter.mprl.local:9443/vsphere-client/#">vCenter MPRL</a><br/>
        <a href="http://192.168.33.209">UPS Szafa rack</a><br/>



    </p>
    <script type="text/javascript">
        $('.iksoris').toggle(false);

        $('.fold_iksoris').click(function() {
            $('.iksoris').toggle(500)
        })
    </script>

</body>
</html>