<!-- Bootstrap core JavaScript-->
     <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <script src="{{ asset('theme/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('theme/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('theme/js/sb-admin-2.min.js') }}"></script>

     <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
     <script>
     const Toast = Swal.mixin({
          toast: true,
          position: 'top',
          showConfirmButton: false,
          showCloseButton: true,
          timer: 5000,
          timerProgressBar:true,
          didOpen: (toast) => {
               toast.addEventListener('mouseenter', Swal.stopTimer)
               toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
     });

     window.addEventListener('alert',({detail:{type,message}})=>{
          Toast.fire({
               icon:type,
               title:message
          })
     })
     </script>


