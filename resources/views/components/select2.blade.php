<div>
    <select {!! $attributes->merge(['class' => 'multiselect-dropdown mt-1 w-full']) !!}>
        {{$slot}}
    </select>
    
        
    @script()
        <script>
            $(document).ready(function() {
                $('.multiselect-dropdown').select2();
        
                $('.multiselect-dropdown').on('change', function() {
                    let data = $(this).val();
                    $wire.query = data;
                })
            });
        </script>
    @endscript
</div>