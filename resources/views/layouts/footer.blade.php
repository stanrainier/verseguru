@extends('layouts.app')

@section('footer_section')
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
                        <img src="../assets/img/brand/logoMain.svg"  alt="Logo" >
                    </div>  
                </div>  
                <div class=" links__container col">
                    <div class="links col">
                        <h1>Links</h1>
                        <div class="links_contents col mb-5">
                            <div class="row">
                                <span >HOME</span>
                                <span class="ml-5">ABOUT US</span>
                            </div>
                            <div class="row mt-2">
                                <span>BIBLE</span>
                                <span class="ml-5">BOOKMARKS</span>
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
@endsection
