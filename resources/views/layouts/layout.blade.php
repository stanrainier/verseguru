<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Verse Guru</title>
  <!-- Favicon -->
  <link rel="icon" href="/img/brand/logo-color.svg" >
  <!-- Styles  -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
        <!-- Montserrat -->
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <!-- Playfair Display -->
            <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Playfair+Display&display=swap" rel="stylesheet">
  <!-- Icons -->
  <!-- Fontawesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Sweetalert-->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="/css/main.css">
  </head>

<style>

    *{
        font-family: 'Montserrat', sans-serif;
    }
    a{
        text-decoration: none;
        color: #343F56;
    }
    a:link {
      text-decoration: none;
      color: #343F56;
    }

    a:visited {
        text-decoration: none;
        color: #343F56;
    }

    a:hover {
        text-decoration: none;
        color: #343F56;
    }

    a:active {
        text-decoration: none;
        color: #343F56;
    }

    .navbar__container {
    display: flex;
    justify-content: space-evenly !important;
    margin-left: 20px;
    }
    .formatlink {
                text-decoration: none;
                color: inherit;
            }

    /* index */
    main{
    background-image: url('/img/background/VerseGuruBG.png'); 
    background-size: cover; height: 100%;
    }
    .main__wrapper{
    display: flex;
    align-items: center;
    height: 80%;
    }
    .welcomeText{
    font-size: 90px;
    color: white;
    font-family: 'Playfair Display', serif;
    text-align: center;
    text-shadow: 5px 5px 18px black;

    }

    .login__module h1{
    font-family: 'Playfair Display', serif;
    color: #343F56;
    text-align: left;
    }
    .login__module a{
    color: #343F56;
    font-size: 12px;
    }
    .login__module span{
    font-size: 12px;
    }
    .login__form input{
    background-color: #f5e6ca;
    color: #343f56;
    height: 50px;
    border-radius: 0px;
    border: none;
    }
    .loginBtn{
    background-color: #343F56;
    border: none;
    color: white;
    padding: 18px 65px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px;
    }

    /* Home */

    .welcomeText{
    font-size: 90px;
    color: white;
    font-family: 'Playfair Display', serif;
    text-align: center;
    }
    .home__header{
        text-align: center;
        justify-content: center;
        margin-top: 10%;
    }
    .homemain__wrapper{
        display: flex;
        flex-direction: column;
    }
    .search__module{
        justify-content: center;
        margin-top: 10%;

    }
    .smart-search{
        background-color: #f5e6ca !important;
        height: 60px;
    }
    .smart_search_card{
        height: 25%;
        width: 45%;
        background-color: white;
        border-radius: 10px;
    }
    .smart_search_body{
        height: 100px;
        padding: 20px;

    }
    .button-smartsearch{
        background-color: #343F56;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        transition-duration: 0.4s;
        margin-left: 20px !important;
        border: solid 1px;
    }
    .button-smartsearch:hover{
        background-color: white;
        color: #343F56;
        border: solid 1px;
    }

    /* signup */
    .signup__module h1{
    font-family: 'Playfair Display', serif;
    color: #343F56;
    text-align: left;
    }
    .signup__module a{
    color: #343F56;
    font-size: 12px;
    }
    .createAccount__container input{
        background-color: #f5e6ca;
        color: #343f56;
    }
    .signupBtn{
    background-color: #343F56;
    border: none;
    color: white;
    padding: 18px 65px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px;
    }
    .signup__form input{
    border-radius: 0px;
    border: none;
    height: 50px;
    }

    /* about us  */
    .aboutus_card{
        background-color:#303b50 !important;
        text-align: center;
        padding: 5%;
        width: 50%;
        border-radius:5px;
    }

    .aboutus_content h1{
        padding: 5%;
        color: white;
        text-align: center;
        font-weight: 900;

    }
    .aboutus_text{
        text-align: justify !important;
    }
    .aboutus_text span{
        color: white;
        font-size:20px;

    }
    .aboutus_content img{
    height: 35%;
    width: 35%;
    }

    /* footer */

        .footer{
        background-color: #343F56;
        width: 100%;
        height: 80%;
        flex-shrink: 0;
    }
    .copyright{
        background-color: #343F56;
        color: white;
        text-align: right;
        padding-right: 40px;
        padding-bottom: 20px;
    }
    .d-flex {
        display: flex !important;
        justify-content: center;
        align-items: center;
    }
    .contact__container{
        height: 50%;
        width: 80%;
    }
    .contact__container h1{
        font-family: 'Playfair Display', serif;
        color: white;
        font-size: 40px;
    }
    .contact-inputs1 input{
        height: 10%;
        width: 100%;

    }
    .contact__footer{
        background-color: #F5E6CA;
        border: none;
        margin-bottom: 20px;
    }
    .contact__footer__message{
        background-color: #F5E6CA;
        border: none;
        margin-bottom: 20px;

    }
    .contact-inputs2 input{
        width: 100%;
        height: 50%;
    }

    .contactBtn{
        background-color: white;
        border: none;
        color: #343F56;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
    }

    .logo__content{
    padding: 5%;
    }
    .logo__content img{
    width: 100%;
    height: 100%;
    }
    .links_contents span{
        font-size: 20px;
        color: white;
    }
    .connectwithus{
    color: white;
    margin-top: 25%;
    }
    .footer__icons{
        width: 50px;
        height: 50px;
        margin-right:30px;
        margin-top:30px;
    }
    .footer__icons i{
        font-size: 30px;
    }
    .links a{
        color: white;

    }
</style>

<body> 
<nav>
<div class="d-flex col">
    <div class="container-fluid col ">
        <div class="navbar-brand d-flex align-items-center" >
        <img src="img/brand/logoMain.svg" alt="Logo" width="7%" height="7%" class="d-inline-block align-text-top ml-5">
        <h1 class="m-4"><a  href="/home">Verse <span style="color: #b77e23;">Guru</span> <a></h1>
    </div>
    </div>
    <div class="container-fluid col w-100">
        <div class="navbar__container mx-auto">
            <div class="d-flex col">
                <div class="navbar__item m-3">
                    <a href="/" class="formatlink"><span> HOME </span></a>
                </div>
                <div class="navbar__item m-3">
                <a href="#" class="formatlink"><span> BIBLE </span></a>
                </div>
                <div class="navbar__item m-3">
                    <a href="#" class="formatlink"><span> BOOKMARKS </span></a>
                </div>
                <div class="navbar__item m-3">
                    <a href="#" class="formatlink"><span> HISTORY </span></a>
                </div>
                <div class="navbar__item m-3">
                    <a href="#" class="formatlink"><span> PROFILE </span></a>
                </div>
            </div>
        </div>
    </div>  
</div>
</nav>
    @yield('content')


    <footer>
    <div class="footer d-flex">
            <div class="contact__container row">
                <div class="contact col ml-5">
                    <h1>Contact Us</h1>
                    <div class="contact-inputs1">
                        <input type="text" placeholder="Name" class="contact__footer"></input>
                        <input type="text" placeholder="Email" class="contact__footer"></input>
                    </div>
                    <div class ="contact-inputs2">
                        <input type="text" placeholder="Message" class="contact__footer__message"></input>
                    </div>
                    <button class="contactBtn">Submit</button>
                </div>
                <div class="logo col">
                    <div class="logo__content">
                        <img src="/img/brand/logoMain.svg"  alt="Logo" >
                    </div>  
                </div>  
                <div class=" links__container col">
                    <div class="links col">
                        <h1>Links</h1>
                        <div class="links_contents mb-5">
                            <div class="d-flex col justify-content-around">
                                <div class="row">
                                    <div class="row mt-4">
                                        <span><a href="/home">HOME</a></span>
                                    </div>
                                    <div class="row mt-4">
                                        <span><a>BIBLE</a></span>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="row mt-4">
                                        <span><a href="/aboutus">ABOUT US</a></span>
                                    </div>
                                    <div class="row mt-4">
                                        <span><a>BOOKMARKS</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="connectwithus col">
                        <h1>Connect With Us</h1>
                        <div class="row">
                            <div class="footer__icons">
                                <i class="fa-brands fa-twitter" ></i>
                            </div>
                            <div class="footer__icons">
                                <i class="fa-brands fa-facebook"></i>
                            </div>
                            <div class="footer__icons">
                                <i class="fa-brands fa-twitter"></i>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
    </div>
    <div class="copyright">
        <span>© 2023 ALL RIGHTS RESERVED  ROKESTA</span>
    </div>
    </footer>
</body>
</html>