<script>
$(.tblscroll).nicesscroll({
    cursorcolor:"#516165",
    cursorwidth:"30px",
    background:"rgba(20,20,20,0.3)",
    cursorborder:"0px",
    cursorborderradius:3,
})

function Confirm(id,eventName, text){
       /*if(products > 0){
           swal('NO SE PUEDE ELIMINAR LA CATEGORIA POR QUE EXISTEN PRODUCTOS RELACIONADOS')
           return;
       }*/
       swal({
           title: 'CONFIRMAR',
           text: text,
           type: 'warning',
           showCancelButton:  true,
           cancelButtonText: 'Cerrar',
           cancelButtonColor: '#fff',
           confirmButtonColor: '#3BEF5C',
           confirmButtonText: 'Aceptar'
       }).then(function(result){
           if(result.value){
               window.livewire.emit(eventName, id)
               swal.close()
           }
       });
   }

</script>