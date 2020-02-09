<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>El viejo continente</title>
    <link rel="stylesheet" href="assets2/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
    <link rel="stylesheet" href="assets2/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets2/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="animate/animate.min.css">
    <link rel="stylesheet" type="text/css" href="fw/all.css">
    <style type="text/css">
        .slider {
    width: 95%;
    margin: auto;
    overflow: hidden;
}

.slider ul {
    display: flex;
    padding: 0;
    width: 400%;
    
    animation: cambio 10s infinite alternate linear;
}

.slider li {
    width: 100%;
    list-style: none;
}

.slider img {
    width: 100%;
}

@keyframes cambio {
    0% {margin-left: 0;}
    20% {margin-left: 0;}
    
    25% {margin-left: -100%;}
    45% {margin-left: -100%;}
    
    50% {margin-left: -200%;}
    70% {margin-left: -200%;}
    
    75% {margin-left: -300%;}
    100% {margin-left: -300%;}
}



    </style>

</head>

<body>
    <nav class="navbar navbar-light navbar-expand bg-light navigation-clean">
        <div class="container"><a class="navbar-brand" href="#">EL VIEJO CONTIENTE</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"></button>
            <div class="collapse navbar-collapse" id="navcol-1"><a class="btn btn-primary ml-auto" role="button" href="back/logout.php">Cerrar sesión</a></div>
        </div>
    </nav>
    <header class="masthead text-white text-center" style="background:url('assets2/img/bg-masthead.jpg')no-repeat center center;background-size:cover;">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <img src="img/logo.png">
                    <div class="slider">
                          <ul>
                          <li>
                          <img src="https://article.images.consumerreports.org/w_767,c_lfill,ar_32:11,f_auto/prod/content/dam/CRO%20Images%202017/Magazine-Articles/April/CR-Autospotlight-Hero-tires-04-17" alt="">
                         </li>
                         <li>
                         <img src="https://tbc.scene7.com/is/image/TBCCorporation/tire-page-banner?$Katana-Hero-Image-993x339$" alt="">
                         </li>
                         <li>
                         <img src="https://openroadautogroup.com/sites/default/files/styles/scale_width_1280/public/assets/page/hero_image/Tires_1.jpeg?itok=VNmV77IU" alt="">
                         </li>
                        
                         </ul>
                    </div>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/CX7_6mL7ksA?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                
            </div>
        </div>
    </header>
    
    <section class="showcase">
        <div class="container-fluid p-0">
            <div class="row no-gutters">
                <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image:url(&quot;img/01.png&quot;);"><span></span></div>
                <div class="col-lg-6 my-auto order-lg-1 showcase-text">
                    <h2>Buena calidad de mercancia</h2>
                    <p class="lead mb-0">Nuestra mercancia es de la mas alta calidad, importada desde europa. Siempre cumpliendo con los certificados de seguridad respectivos.</p>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-6 text-white showcase-img" style="background-image:url(&quot;img/02.png&quot;);"><span></span></div>
                <div class="col-lg-6 my-auto order-lg-1 showcase-text">
                    <h2>Personal capacitado</h2>
                    <p class="lead mb-0">El personal del viejo continente import es un personal experimentado y estudiado, ofreciendo al cliente mayor seguridad y confianza a la hora de realizar una consulta.</p>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image:url(&quot;img/03.png&quot;);"><span></span></div>
                <div class="col-lg-6 my-auto order-lg-1 showcase-text">
                    <h2>Excelente relacion calidad-precio</h2>
                    <p class="lead mb-0">Ofrecemos los productos de mas alta calidad del mercado, al mejor precio posible.</p>
                </div>
            </div>
        </div>
    </section>
    
    <section class="call-to-action text-white text-center" style="background:url(&quot;assets2/img/bg-masthead.jpg&quot;) no-repeat center center;background-size:cover;">
        <div class="overlay"></div>
       
    </section>
    
    <script src="assets2/js/jquery.min.js"></script>
    <script src="assets2/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets2/js/bs-animation.js"></script>
    <script src="fw/all.js"></script>

</body>

</html>