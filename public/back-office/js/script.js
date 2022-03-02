// jQuery(document).ready(function () {
//     jQuery('.add-another-collection').click(function (e) {
//         var list = $("#diplomes-fields-list");
//         var counter = list.data('widget-counter') | list.children().length;
//         var newWidget = list.attr('data-prototype');
//         newWidget = newWidget.replace(/__name__/g, counter);
//         counter++;
//         list.data('widget-counter', counter);
//
//         var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
//         newElem.appendTo(list);
//         newElem.append('<a href="#" class="remove-tag" style="color: darkred">remove</a>');
//         $('.remove-tag').click(function(e) {
//             e.preventDefault();
//
//             $(this).parent().remove();
//
//         });
//     });
// });
// On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
$('.btn-collection-add').click(function (e) {
    addDocumentation($($(this).data('prototype-add')));
    e.preventDefault(); // évite qu'un # apparaisse dans l'URL
    return false;
});

// La fonction qui ajoute un formulaire CategoryType
function addDocumentation($container) {
    var index = $container.find(':input').length;
    // Dans le contenu de l'attribut « data-prototype », on remplace :
    // - le texte "__name__" qu'il contient par le numéro du champ
    var template = $container.attr('data-prototype').replace(/__name__/g, index);
    // On crée un objet jquery qui contient ce template
    var $prototype = $(template);
    // On ajoute le prototype modifié à la fin de la balise <div>
    $container.append($prototype);
    // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
    index++;
}

// Ajout du listener sur le clic du lien pour effectivement supprimer l'entrée de la collection.
$(document).on('click', '.btn-collection-delete', function (e) {
    $(this).closest('.panel').remove();
    e.preventDefault(); // évite qu'un # apparaisse dans l'URL
    return false;
});
$(document).ready(function () {
    $('form #btn-ok').click(function (e) {
        let $form = $(this).closest('form');
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Vous ne pourrez pas revenir en arrière !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimez-le !\n',
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                $form.submit();
            }
        })
    });
});