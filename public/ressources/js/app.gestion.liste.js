    // var lastDraw = false;
    //
    // $(function() {
    //     $('.table').each(function() {
    //         $(this).dataTable({
    //             language: DATATABLE.I18N.FR,
    //
    //             dom:            [
    //                 "<'row'<'col-12 col-md-6'Bl><'col-12 col-md-6'f>>",
    //                 "<'row'<'col-12'tr>>",
    //                 "<'row'<'col-12 col-md-5'i><'col-12 col-md-7'p>>"
    //             ].join(''),
    //
    //             drawCallback:   onDatatableDraw,
    //             createdRow:     onDatatableRowCreated,
    //
    //             pageLength:     10,
    //             lengthChange:   false,
    //
    //             columnDefs: [
    //                 { targets: 'optional', visible: false },
    //                 { targets: 'actions', orderable: false, sortable: false, searchable: false },
    //             ],
    //
    //             search:         {
    //                 regex:           true,
    //                 caseInsensitive: true,
    //                 smart:           true
    //             },
    //
    //             buttons: []
    //         });
    //     });
    // });
    //
    // function onDatatableRowCreated( row, data, dataIndex ) {
    //     var $row = $(row);
    //
    //     // On gère l'affichage des tooltips
    //     $row.find('> td.actions [title]').each(function(idx, that) {
    //         $(that).tooltip({
    //             container: 'body',
    //             boundary: 'viewport',
    //             placement: that.dataset.placement || 'top',
    //         });
    //     });
    //
    //     // La gestion de la suppression d'un suivi
    //     $row.find('.action-delete').on('click', function(evt) {
    //         const $link = $(this);
    //
    //         event.preventDefault();
    //         event.stopPropagation();
    //         event.stopImmediatePropagation();
    //
    //         const mdlA = new Modal({
    //             type : Modal.TYPE_PROMPT,
    //             title : "Confirmation de suppression",
    //             size : Modal.SIZE_NORMAL,
    //             content : json2xml({
    //                 'div': {
    //                     'p': [
    //                         {
    //                             '@class': 'm-0',
    //                             '#text': "Vous êtes sur le point de supprimer un élément."
    //                         },{
    //                             '#text': "Continuer ?"
    //                         }
    //                     ]
    //                 }
    //             }),
    //             actions : {
    //                 "<strong>OUI</strong>, confirmer" : {
    //                     extrasClass : "apply",
    //                     onClick : function() {
    //                         mdlA.hide();
    //
    //                         const mdlB = Modal.working('En cours de traitement...', json2xml({
    //                             'p': {
    //                                 'i': {
    //                                     '@class': 'fa fa-spin fa-cog mr-3'
    //                                 },
    //                                 'span': 'Suppression en cours, veuillez patienter...'
    //                             }
    //                         }));
    //
    //                         // On envoie le formulaire au serveur
    //                         $.ajax({
    //                             url: $link.attr('href'),
    //                             type: 'DELETE',
    //                             cache: false,
    //                             dataType: 'json',
    //                             timeout: 60000,
    //                             success: function(json)
    //                             {
    //                                 document.location.reload(true);
    //
    //                             }
    //                         });
    //
    //                     }
    //                 },
    //                 "<strong>NON</strong>, annuler" : {
    //                     extrasClass : "cancel",
    //                     onClick : function() {
    //                         mdlA.hide();
    //                     }
    //                 }
    //             }
    //         }).show();
    //
    //         return false;
    //     });
    // }
    //
    // function onDatatableDraw() {
    //     var now = moment(),
    //         $dt = $(this),
    //         dt = $dt.DataTable(),
    //         timer;
    //
    //     if (!lastDraw) {
    //         lastDraw = now;
    //
    //         var checkVisibility = function() {
    //             if ($dt.is(':visible')) {
    //                 if (timer) {
    //                     clearTimeout(timer);
    //                 }
    //
    //                 // On ajuste la taille des colonnes
    //                 dt.columns.adjust().draw();
    //             } else {
    //                 timer = clearTimeout(checkVisibility, 1);
    //             }
    //         };
    //
    //         checkVisibility();
    //     }
    // }