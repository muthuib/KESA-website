@extends('layouts.app')

@section('content')

    <div class="pagetitle">
        <h1 class="mt-5 d-flex align-items-center gap-3">
            Contact Us
            <a href="https://www.facebook.com/kesa.kenya?mibextid=ZbWKwL" class="social-icon facebook" target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/kesa_kenya?t=9VRLpQi_IiXHRdU81n_iLQ&s=09" class="social-icon twitter" target="_blank">
                <img src="/assets/images/x-logo.png" alt="Twitter X" width="20" height="20">
            </a>
            <a href="https://www.linkedin.com/company/kenya-economics-students-association/" class="social-icon linkedin" target="_blank">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="https://www.instagram.com/kesa_kenya?igsh=YjcwdXptM254d3Fq" class="social-icon instagram" target="_blank">
                <i class="fab fa-instagram"></i>
            </a>
        </h1>

    </div><!-- End Page Title -->

    <section class="section contact">
 @foreach($contacts as $contact)
      <div class="row gy-4">

        <div class="col-xl-6">

          <div class="row">
            <div class="col-lg-6">
              <div class="info-box card">
                <i class="bi bi-geo-alt"></i>
                <h3>Address</h3>
                <p> {{ $contact->address ?: 'No address available' }}</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box card">
                <i class="bi bi-telephone"></i>
                <h3>Call Us</h3>
                <p><a href="tel:{{ $contact->phone }}">{{ $contact->phone ?: 'No phone available' }}</a></p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box card">
                <i class="bi bi-envelope"></i>
                <h3>Email Us</h3>
                <p><a href="mailto:{{ $contact->email }}">{{ $contact->email ?: 'No email available' }}</a></p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info-box card">
                <i class="bi bi-clock"></i>
                <h3>Open Hours</h3>
                <p>Monday - Friday<br>9:00AM - 05:00PM</p>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-6">
          <div class="card p-4">
            <form action="forms/contact.php" method="post" class="php-email-form">
              <div class="row gy-4">

                <div class="col-md-12 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                </div>


                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div>

        </div>

      </div>
  @endforeach
    </section>
    <style>
    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        font-size: 0.7rem;
        border-radius: 50%;
        color: #fff;
        transition: background-color 0.3s, transform 0.3s;
    }

    .social-icon:hover {
        transform: scale(1.1);
    }

    .facebook { background-color: #3b5998; }
    .twitter { background-color: #1da1f2; }
    .linkedin { background-color: #0077b5; }
    .instagram { background: radial-gradient(circle at 30% 30%, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.8rem;
            text-align: center;
        }
        .contact-card {
            padding: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.5rem;
        }
        .social-icon {
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
        }
    }
</style>
  @endsection
