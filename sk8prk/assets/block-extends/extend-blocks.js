/* global wp */
( function( blocks ) {
    var styles = [
        {
            name: "core/group",
            options: {
                name: "outline",
                label: "Outline",
            },
        },
        {
            name: "core/cover",
            options: {
                name: "duotone",
                label: "Duotone",
            },
        },
        {
            name: "core/gallery",
            options: {
                name: "duotone",
                label: "Duotone",
            },
        },
    ];
    
    styles.forEach ( function(style){
        blocks.registerBlockStyle( style.name, style.options );
    });
}( wp.blocks ) );