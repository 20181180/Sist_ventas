<script>
    document.addEventListener('DOMContentLoaded', function() {
      
        window.livewire.on('scan-ok', Msg => {
            // $('#theModal').modal('hide');
            noty(Msg)
         });
         window.livewire.on('scan-notfound', Msg => {
            // $('#theModal').modal('hide');
            noty(Msg,2)
         });
         window.livewire.on('no-stock', Msg => {
            // $('#theModal').modal('hide');
            noty(Msg,3)
         });
         window.livewire.on('sale-error', Msg => {
            // $('#theModal').modal('hide');
            noty(Msg)
         });

         window.livewire.on('print-ticket', saleId => {
            // $('#theModal').modal('hide');
           window.open("print://"+saleId, '_blanck');
         });    
    });
</script>