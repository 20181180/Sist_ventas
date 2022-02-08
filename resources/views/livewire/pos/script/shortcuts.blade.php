<script>
    var listener = new window.keypress.Listener();

    listener.simple_combo("z", function() {
        livewire.emit('saveSale')
    })

    listener.simple_combo("x", function() {
        document.getElementById('cash').value = ''
        document.getElementById('cash').focus()
    })

    listener.simple_combo("c", function() {
        var total = parseFloat(document.getElementById('hiddenTotal').value)
        if (total > 0) {
            Confirm(0, 'clearCart', '¿confirmar de eliminar la venta?')
        } else {
            noty('AGREGAR PRODUCTOS A LA VENTA')
        }

    })
    listener.simple_combo("s", function() {
        var efectivo = parseFloat(document.getElementById('cash').value)

        livewire.emit('ACashAmano',efectivo)
    })
</script>
