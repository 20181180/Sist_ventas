<div>
    <ul class="tabs tab-pills">

        <li><a href="javascript:void(0);" class="tabmenu bg-dark" data-toggle="modal" data-target="#modalxd"><i class="fas fa-user-astronaut" style="font-size:22px;"></i> Agregar</a></li>
    </ul>
    @include('livewire.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
            $('#modalxd').modal('show');
            noty(msg)
        });
        window.livewire.on('category-added', msg => {
            $('#modalxd').modal('hide');
            noty(msg)
        });
        window.livewire.on('category-updated', msg => {
            $('#modalxd').modal('hide');
            noty(msg)
        });
    });
</script>