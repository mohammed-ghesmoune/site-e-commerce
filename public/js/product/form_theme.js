$(document).ready(function () {
    function updateColorCounter() {
        const count = + $('#product_colors div.color').length;
        $('#color-counter').val(count)
    }
    updateColorCounter();

    $('#add-color').click(function (e) { 
        // const colorIndex = $('#product_colors div.color').length;
        const colorIndex = + $('#color-counter').val();
       // console.log(colorIndex);

        var colorPrototype = $('#product_colors').data('prototype').replace(/colors___name__/g, 'colors_' + colorIndex);
        colorPrototype = colorPrototype.replace(/\[colors\]\[__name__\]/g, '[colors][' + colorIndex + ']');

        $('#product_colors').append(colorPrototype);
        $('#color-counter').val(colorIndex + 1);
        colorDelete();
        imageAdd();
        imageDelete();
        sizeAdd();
        sizeDelete();

    })

    function colorDelete() {
        $('button[data-action="delete-color"]').click(function () {
            const target = this.dataset.target;
            $(target).parent().parent().remove();
        })
    }
    colorDelete();
    function updateImageCounter() {
        $('#product_colors div.color').each(function () {
            const count = +$(this).find('.image').length;
            $(this).find('input[id^="image_counter"]').val(count);

        });
    }
    updateImageCounter();

    function imageAdd() {
        $('button[data-action="add-image"]').click(function (e) {
            const parent = this.dataset.parent;
            // const imageIndex = $(parent).find('.image').length;
            const imageIndex = + $('#image_counter_' + parent.substring(1, parent.length)).val();
            //console.log(imageIndex);

            const imagePrototype = $(parent).data('prototype').replace(/__name__/g, imageIndex);

            $(parent).append(imagePrototype);
            $('#image_counter_' + parent.substring(1, parent.length)).val(imageIndex + 1);


            imageDelete();

        });
    }

    imageAdd();

    function imageDelete() {
        $('button[data-action="delete-image"]').click(function () {
            const target = this.dataset.target;
            $(target).parent().parent().remove();
        })
    }
    imageDelete();

    function updateSizeCounter() {
        $('#product_colors div.color').each(function () {
            const count = +$(this).find('.size').length;
            $(this).find('input[id^="size_counter"]').val(count);

        });
    }
    updateSizeCounter();

    function sizeAdd() {
        $('button[data-action="add-size"]').click(function (e) {
            const parent = this.dataset.parent;
            const sizeIndex = + $('#size_counter_' + parent.substring(1, parent.length)).val();
            const sizePrototype = $(parent).data('prototype').replace(/__name__/g, sizeIndex);

            $(parent).append(sizePrototype);
            $('#size_counter_' + parent.substring(1, parent.length)).val(sizeIndex + 1);


            sizeDelete();

        });
    }

    sizeAdd();
    function sizeDelete() {
        $('button[data-action="delete-size"]').click(function () {
            const target = this.dataset.target;
            $(target).parent().parent().remove();
        })
    }
    sizeDelete();


});