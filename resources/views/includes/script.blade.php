<script>
  //message with toastr
  @if(session()->has('success'))

    toastr.success('{{ session('success') }}', 'SUCCESS!');

  @elseif(session()->has('error'))

    toastr.error('{{ session('error') }}', 'ERROR!');

  @endif
</script>