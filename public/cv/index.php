<?php

$host = '127.0.0.1';
$db   = 'sampleDB';
$user = 'sample_admin';
$pass = '456vxFsosl9XvhODlQCQ';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$stmt = $pdo->query("
    SELECT
        id,
        sort_order,
        publication_type,
        authors,
        title,
        venue,
        year,
        volume,
        issue,
        pages,
        url
    FROM publication
    ORDER BY sort_order ASC, year DESC, id ASC
");
$publications = $stmt->fetchAll();

function h($value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function formatPublicationMeta(array $publication): string
{
    $html = '';

    if (!empty($publication['venue'])) {
        $html .= '<i>' . h($publication['venue']) . '</i>';
    }

    if (!empty($publication['year'])) {
        $html .= ($html !== '' ? ' ' : '') . h($publication['year']);
    }

    if (!empty($publication['volume'])) {
        $html .= ', ' . h($publication['volume']);
    }

    if (!empty($publication['issue'])) {
        $html .= ', ' . h($publication['issue']);
    }

    if (!empty($publication['pages'])) {
        $html .= ', ' . h($publication['pages']);
    }

    return $html;
}

function publicationUrlLabel(?string $url): string
{
    $url = trim((string)$url);

    if ($url === '') {
        return '';
    }

    if (strpos($url, 'https://doi.org/') === 0 || strpos($url, 'http://doi.org/') === 0) {
        return 'doi';
    }

    return 'link';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Maxim Moscotin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jpswalsh/academicons@1/css/academicons.min.css">
    <link rel="stylesheet" href="/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/b4327afbd7.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="container text-center pt-4">
    <h1 class="display-3">Maxim Moscotin</h1>
    <p><a target="_blank" class="no-link" href="mailto:maxim.moscotin@ftmc.lt">maxim.moscotin@ftmc.lt</a> | <a class="no-link" href="tel:+37060122021">+370 60122021</a> <a target="_blank" href="https://t.me/enottie" target="_blank"><i class="fa-brands fa-telegram"></i></a> <a target="_blank" class="whatsapp-color" href="https://wa.me/79257007176" target="_blank"><i class="fa-brands fa-whatsapp"></i></a> </p>
    <div class="row">
        <div class="col-lg my-3">
            <div class="card">
                <h4 class="card-header">Education</h4>
                <!--img class="w-50 mx-auto card-img-top" src="/img/mipt_logo.jpg" alt="Moscow Institute of Physics and Technology"-->
                <div class="card-body">
                    <h5 class="card-title">Moscow Institute of <br />Physics and Technology</h5>
                    <p class="card-title"><strong>BS in Mathematics and Computer Science</strong></p>
                    <p class="card-text">2015 | Moscow, Russia</p>
                    <p class="card-title"><strong>MS in Mathematics and Computer Science</strong></p>
                    <p class="card-text">2017 | Moscow, Russia</p>
                    <hr />
                    <h5 class="card-title">Center for Physical  <br />Sciences and Technology</h5>
                    <p class="card-title"><strong>PhD in Physics</strong></p>
                    <p class="card-text">In progress | Vilnius, Lithuania</p>
                </div>
            </div>

            <div class="card my-3">
                <h4 class="card-header">Professional skills</h4>
                <!--img class="w-50 mx-auto card-img-top" src="/img/mipt_logo.jpg" alt="Moscow Institute of Physics and Technology"-->
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h5 class="card-title my-2">CLEAN ROOM</h5>
                        <div class="card-text text-start">
                            <ul>
                                <li>Electron-beam lithography</li>
                                <li>Scanning electron microscopy</li>
                                <li>Photolithography</li>
                                <li>Electron-beam/thermal material deposition</li>
                                <li>Plasma-chemical etching</li>
                            </ul>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h5 class="card-title my-2">PROGRAMMING</h5>
                        <div class="card-text text-start">
                            <ul>
                                <li>PHP/Laravel</li>
                                <li>Python for DS</li>
                                <li>LabVIEW</li>
                                <li>Bash/LINUX architecture</li>
                                <li>HTML • CSS • JS • SQL</li>
                            </ul>
                        </div>
                    </li>
                    <li class="list-group-item my-2">
                        <h5 class="card-title">ACADEMIC</h5>
                        <div class="card-text text-start">
                            <ul>
                                <li>LabVIEW course development and tutorship</li>
                                <li>Optical physics laboratory works assistance</li>
                            </ul>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
        <div class="col-lg my-3">
            <div class="card">
                <h4 class="card-header">Research experience</h4>
                <!--img class="w-50 mx-auto card-img-top" src="/img/mipt_logo.jpg" alt="Moscow Institute of Physics and Technology"-->
                <div class="card-body">
                    <h5 class="card-title">Terahertz Photonics Laboratory</h5>
                    <p class="card-title"><strong>RESEARCH FELLOW <br /> From Nov 2022 | FTMC</strong></p>
                    <p class=" text-start">THz detection aimed experimental research of 2D-material (e.g. AlGaN/GaN, graphene) based high electron mobility transistors (HEMTs).</p>
                    <hr />
                    <h5 class="card-title">Carbon Nanomaterials Laboratory</h5>
                    <p class="card-title"><strong>RESEARCH FELLOW <br /> Sep 2018 – Oct 2022 | MIPT</strong></p>
                    <p class=" text-start">Experimental work on graphene and carbon nanotube based FET detectors in THz
                        range irradiation. Clean room fabrication of experimental devices using
                        maskless laser lithography, e-beam lithography, thermal evaporation and
                        plasma-chemical etching.</p>
                    <hr />
                    <h5 class="card-title">Quantum Detectors Laboratory</h5>
                    <p class="card-title"><strong>ENGINEER <br /> Jun 2015 – Jun 2021 | MSPU</strong></p>
                    <p class=" text-start">Development of LabView and web-based software for experimental data acquisition
                        and processing. Experimental device fabrication using masked
                        photolithography, e-beam lithography, scanning electron microscopy, e-beam
                        evaporation and plasma-chemical etching.</p>
                    <hr />
                    <h5 class="card-title">Laboratory of Scientific Data Integration and Visualization</h5>
                    <p class="card-title"><strong>JUNIOR RESEARCHER <br /> Sep 2013 – Jun 2015 | KI</strong></p>
                    <p class=" text-start">Java project implementation on weather data acquisition, interpretation and
                        visualization. Development of a web-service with API for data communication between a
                        noSQL-database and a front-end vizualization interface.</p>
                </div>
            </div>
        </div>
        <?php /* <div class="col-lg-4">

            <div class="card my-3">
                <h4 class="card-header">Languages</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                <!--img class="w-50 mx-auto card-img-top" src="/img/mipt_logo.jpg" alt="Moscow Institute of Physics and Technology"-->
                <div class="card-text text-start">
                    <ul>
                        <li>Native: Russian</li>
                        <li>Fluent: English</li>
                        <li>Beginner: Polish</li>
                    </ul>
                </div>
                    </li>
                </ul>
            </div>

            <div class="card my-3">
                <h4 class="card-header">Some achievements</h4>
                <!--img class="w-50 mx-auto card-img-top" src="/img/mipt_logo.jpg" alt="Moscow Institute of Physics and Technology"-->
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <h5 class="card-title my-2">COMPLETED COURSES</h5>
                        <div class="card-text text-start">
                            <ul>
                                <li>Machine Learning and Data Analysis (2020)</li>
                                <li>Java Development (2021)</li>
                            </ul>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h5 class="card-title my-2">ENGINEERING</h5>
                        <div class="card-text text-start">
                            <ul>
                                <li>Software and hardware development of arduino-based transition stage controllers</li>
                                <li>Implementation of a web-service for fabrication and experimental data access</li>
                                <li>Fabrication of data acquisition modules for student laboratory works</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
 */ ?>

        <!--div class="card my-3">
            <h4 class="card-header">Hobbies</h4>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">

            <img class="w-50 mx-auto card-img-top" src="/img/mipt_logo.jpg" alt="Moscow Institute of Physics and Technology">
            <div class="card-text text-start">
                <ul>
                    <li>Travelling across the globe</li>
                    <li>Out-of-the-city cycling</li>
                    <li>Table tennis</li>
                    <li>Automotive enthusiast</li>
                    <li>Drone filming</li>
                </ul>
            </div>
                </li>
            </ul>
        </div-->

        <!--div class="card my-3">
            <h4 class="card-header">Social</h4>
            <img class="w-50 mx-auto card-img-top" src="/img/mipt_logo.jpg" alt="Moscow Institute of Physics and Technology">
            <div class="card-text text-center mt-2 mb-0">
                <a target="_blank" href="https://scholar.google.com/citations?user=v1d0s90AAAAJ&hl=en"><i class="ai h3 ai-google-scholar-square mx-3"></i></a>
                <a target="_blank" href="https://www.facebook.com/moscotin"><i class="fa h3 fa-social fa-facebook mx-3"></i></a>
                <a target="_blank" href="https://wa.me/79257007176"><i class="fa h3 fa-social fa-whatsapp mx-3"></i></a>
                <a target="_blank" href="https://t.me/enottie"><i class="fa h3 fa-social fa-telegram mx-3"></i></a>
                <a target="_blank" href="https://www.instagram.com/enottie/"><i class="fa h3 fa-social fa-instagram mx-3"></i></a>
            </div>
        </div-->
    </div>
</div>

<div class="row mb-4" style="page-break-before: always">
    <div class="col-lg-12">
        <div class="card my-3">
            <h4 class="card-header text-center">Publications</h4>
            <!--img class="w-50 mx-auto card-img-top" src="/img/mipt_logo.jpg" alt="Moscow Institute of Physics and Technology"-->
            <div class="card-text text-start mt-3 mx-3">
                <?php if (empty($publications)) { ?>
                    <p class="text-muted">No publications found.</p>
                <?php } else { ?>
                    <ol>
                        <?php foreach ($publications as $publication) {
                            $meta = formatPublicationMeta($publication);
                            $url = trim((string)($publication['url'] ?? ''));
                            $urlLabel = publicationUrlLabel($url);
                            ?>
                            <li class="mb-2">
                                <p class="my-0">
                                    <?php echo h($publication['authors']); ?>;
                                    <strong><?php echo h($publication['title']); ?></strong>.
                                    <?php if ($meta !== '') { ?>
                                        <?php echo $meta; ?>.
                                    <?php } ?>
                                    <?php if ($url !== '') { ?>
                                        <?php echo h($urlLabel); ?>:
                                        <a target="_blank"
                                           rel="noopener noreferrer"
                                           class="no-link"
                                           href="<?php echo h($url); ?>">
                                            <?php echo h($url); ?>
                                        </a>
                                    <?php } ?>
                                </p>
                            </li>
                        <?php } ?>
                    </ol>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
<!-- Hi there! Thank you for being interested in my source code. If you have any questions do not hesitate to contact me by email or Telegram :3 -->
</body>
</html>
