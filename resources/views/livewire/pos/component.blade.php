<div>
    <style></style>

    <div class="row layout-top-spacing">

    <div class="col-sm-12 col-md-8">
        @include('livewire.pos.partials.detail')
    </div>

    <div class="col-sm-12 col-md-4">
        <!--total-->
        @include('livewire.pos.partials.total')

        <!--Denominaciones-->
        @include('livewire.pos.partials.coins')
    </div>

    </div>
</div>

<script>
/* @include('livewire.pos.script.events')
 @include('livewire.pos.script.general')
 @include('livewire.pos.script.scan')
 @include('livewire.pos.script.shortcuts')
 */
</script>
