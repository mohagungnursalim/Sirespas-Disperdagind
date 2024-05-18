<!-- Footer -->
<footer class="text-center text-lg-start bg-light text-muted">
  <!-- Section: Social media -->
  <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
    <!-- Left -->
    {{-- <div class="me-5 d-none d-lg-block">
      <span>Terhubung dengan kami di jejaring sosial:</span>
    </div> --}}
    <!-- Left -->

    <!-- Right -->
    <div>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-google"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-linkedin"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-github"></i>
      </a>
    </div>
    <!-- Right -->
  </section>
  <!-- Section: Social media -->

  <!-- Section: Links  -->
  <section class="">
    <div class="container text-center text-md-start mt-5">
      <!-- Grid row -->
      <div class="row mt-3">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-3"></i>
            @foreach ($settings as $setting )
              {{ $setting->nama }}
            @endforeach
            
          </h6>
          <p>

            @foreach ($settings as $setting )
            {{ $setting->text }}
            @endforeach
          </p>
        </div>
        <!-- Grid column -->

       
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
          <p>
            @foreach ($settings as $setting )
            {{ $setting->alamat }}
            @endforeach
          </p>
          <p>
            <i class="fas fa-envelope me-3"></i>
            @foreach ($settings as $setting )
            {{ $setting->email }}
            @endforeach
          </p>
          <p><i class="fas fa-phone me-3"></i>
            @foreach ($settings as $setting )
            {{ $setting->telepon }}
            @endforeach
          </p>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->

  <!-- Copyright -->
  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    Copyright &copy; @php echo date('Y') @endphp
                
    @foreach ($settings as $setting )
    {{ $setting->copyright }}
    @endforeach.
                             
    <a class="text-reset fw-bold" href="/"></a>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->