@extends('layouts.app')

@section('title', 'Contact Us | QuickTech Cambodia')

@section('content')
<div class="qt-page-head">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact</li>
            </ol>
        </nav>
        <h1>Get in touch</h1>
        <p>Questions about stock, custom builds, warranty or delivery? We're happy to help.</p>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4 mb-4">
        <div class="col-lg-5">
            <section class="qt-card qt-card__body h-100">
                <h2 class="qt-card__title mb-4">Store information</h2>

                <div class="qt-info-item">
                    <span class="qt-info-item__icon"><i class="fa-solid fa-location-dot"></i></span>
                    <div><h3>Address</h3><p>Phnom Penh, Cambodia (near city center)</p></div>
                </div>
                <div class="qt-info-item">
                    <span class="qt-info-item__icon"><i class="fa-solid fa-phone"></i></span>
                    <div><h3>Hotline</h3><p><a href="tel:015646581" class="text-dark fw-semibold">015 646 581</a> / <a href="tel:012646581" class="text-dark fw-semibold">012 646 581</a></p></div>
                </div>
                <div class="qt-info-item">
                    <span class="qt-info-item__icon"><i class="fa-brands fa-telegram"></i></span>
                    <div><h3>Telegram</h3><p><a href="https://t.me/QUICKTECHCAM" target="_blank" rel="noopener" class="text-primary fw-semibold">@QUICKTECHCAM</a></p></div>
                </div>
                <div class="qt-info-item">
                    <span class="qt-info-item__icon"><i class="fa-regular fa-clock"></i></span>
                    <div><h3>Opening hours</h3><p>Monday – Sunday, 8:00 AM – 7:30 PM</p></div>
                </div>

                <div class="mt-4 pt-3" style="border-top: 1px solid var(--qt-border);">
                    <div class="small fw-semibold text-dark mb-2">Payment methods</div>
                    <div class="qt-pay-icons justify-content-start">
                        <span>ABA KHQR</span><span>ACLEDA KHQR</span><span>Wing Bank</span><span>Cash on delivery</span>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-lg-7">
            <section class="qt-card qt-card__body h-100">
                <h2 class="qt-card__title mb-1">Send us a message</h2>
                <p class="text-muted small mb-4">We'll get back to you as soon as possible.</p>

                <form action="#" method="POST" onsubmit="showCcToast('Thank you! Your message has been sent to QuickTech.'); this.reset(); return false;">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="cName">Your name</label>
                            <input type="text" id="cName" class="form-control" placeholder="Full name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="cPhone">Phone / Telegram</label>
                            <input type="text" id="cPhone" class="form-control" placeholder="012 345 678" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="cSubject">Subject</label>
                            <input type="text" id="cSubject" class="form-control" placeholder="e.g. ASUS Vivobook / RTX 4060 build">
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="cMsg">Message</label>
                            <textarea id="cMsg" class="form-control" rows="4" placeholder="How can we help?" required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane fa-sm"></i> Send message</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <div class="qt-card overflow-hidden">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125134.4079555198!2d104.81452945!3d11.5796636!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109513dc76a6be3%3A0x9c010ee85ab525bb!2sPhnom%20Penh!5e0!3m2!1sen!2skh!4v1700000000000!5m2!1sen!2skh" width="100%" height="360" style="border:0; display:block;" allowfullscreen loading="lazy" title="QuickTech Cambodia location map"></iframe>
    </div>
</div>
@endsection
