<footer class="main-footer">
    <div class="footer-left">
      Copyright &copy; 2025 <div class="bullet"></div> Design By <a >Kelompok 3</a>
    </div>
    <div class="footer-right">
    </div>
  </footer>
</div>
</div>


  <!-- General JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
 </script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{  asset('assets/js/stisla.js') }}"></script>
  {{-- ... skrip lainnya ... --}}
  <script src="{{  asset('assets/js/scripts.js') }}"></script>
  <script src="{{  asset('assets/js/myscript.js') }}"></script> <script src="{{  asset('assets/js/page/index.js') }}"></script>
  <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
  data-client-key={{ config('midtrans.client_key') }}></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  {{-- <script src="{{  secure_asset('assets/js/stisla.js') }}"></script> --}}
  <script src="{{  asset('assets/js/stisla.js') }}"></script>
  <!-- JS Libraies -->
  <script src="{{  asset('node_modules/jquery-sparkline/jquery.sparkline.min.j') }}s"></script>

  <script src="{{  asset('node_modules/owl.carousel/dist/owl.carousel.min.js') }}"></script>
  <script src="{{  asset('node_modules/summernote/dist/summernote-bs4.js') }}"></script>
  <script src="{{  asset('node_modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
  <script src="{{  asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{  asset('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <!-- Template JS File -->
  <script src="{{  asset('assets/js/scripts.js') }}"></script>
  <script src="{{  asset('assets/js/myscript.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{  asset('assets/js/page/index.js') }}"></script>
  <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
  data-client-key={{ config('midtrans.client_key') }}></script>

...
  <script src="{{  asset('assets/js/myscript.js') }}"></script>

  <script src="{{  asset('assets/js/page/index.js') }}"></script>
  <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
  data-client-key={{ config('midtrans.client_key') }}></script>
  
  {{-- TAMBAHKAN BARIS INI JIKA BELUM ADA --}}
  @stack('scripts')

</body>
</html>
  
</body>
</html>
