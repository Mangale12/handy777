
$(document).ready(function() {


    if ($('.datatable').length > 0) {
        $('.datatable').DataTable({
            pageLength: 100,
            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
            buttons: [{
                    extend: 'copy',
                    className: 'btn-sm btn-info',
                    title: 'Gamers',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-sm btn-success',
                    title: 'Gamers',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-sm btn-warning',
                    title: 'Gamers',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible',
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-sm btn-primary',
                    title: 'Gamers',
                    pageSize: 'A2',
                    header: false,
                    footer: true,
                    exportOptions: {
                        // columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-sm btn-success',
                    title: 'Gamers',
                    // orientation:'landscape',
                    pageSize: 'A2',
                    header: true,
                    footer: false,
                    orientation: 'landscape',
                    exportOptions: {
                        // columns: ':visible',
                        stripHtml: false
                    }
                }
            ],
        });
    }
    $('.select2').select2({
        dropdownParent: $('.popup')
    });
    $('.game-btn').on('click', function(e) {
        var gameTitle = $(this).attr('data-title');
        window.location.replace('/table?game=' + gameTitle);
    });
    $(function() {
        $(".search-undo").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("tbody > tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    $(function() {
        $(".search-user").on("keyup", function() {
            var url  = window.location.origin + '/table-search';
            var value = $(this).val().toLowerCase();
            var activeGameId = $('.activeGameId').val();
            $.ajax({
                url: url,
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    value: value,
                    activeGameId: activeGameId,
                },
                success:function(data){
                    $('.authorTable').html(data)
                }
            })
            // $("tbody > tr").filter(function() {
            //     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            // });
        });
    });

    $('.user-history').on('click', function(e) {
        // $('#exampleModalCenter3').modal('show');
        var type = $(this).attr("data-type");
        $('.load-type').text(type);
        var userId = $(this).attr("data-userId");
        var game = $(this).attr("data-game");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "POST";
        var ajaxurl = '/user-history';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {
                "type": type,
                "userId": userId,
                "game": game,
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                console.log(data);
                if (data !== '') {
                    optionLoop = '';
                    options = data;
                    var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    options.forEach(function(index) {
                        var date_format = new Date(index.created_at);
                        var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        optionLoop +=
                            '<tr><td class="text-center">' + a + '</td><td class="text-center">$ ' + index.amount_loaded + '</td><td class="text-center">' + index.created_by.name + '</td></tr>';
                    });
                } else {
                    optionLoop = '<tr><td>No History</td></tr>';
                }
                $(".user-history-body").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
    });
    $('.user-gameids').on('click', function(e) {
        var userId = $(this).attr("data-userId");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "POST";
        var ajaxurl = '/gameids';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {
                "userId": userId,
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                if (data != '') {
                    optionLoop = '';
                    options = data;
                    options.forEach(function(index) {
                        optionLoop +=
                            '<tr><td class="text-center">' + index.account.name + '</td><td class="text-center">' + index.game_id + '</td>';
                    });
                } else {
                    optionLoop = '<tr><td>No History</td></tr>';
                }
                $(".user-game-ids").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
    });

    $('.redeem-history').on('click', function(e) {
        $('#exampleModalCenter1').modal('show');
    });
    $('.refer-history').on('click', function(e) {
        $('#exampleModalCenter4').modal('show');
    });
    $('.history-btn').on('click', function(e) {
        $('#exampleModalCenter').modal('show');
    });
    
    $('.filter-undo').on('click', function(e) {
        e.stopImmediatePropagation();
        console.log('a');
        var historyType = '';
        
        var filter_type = $('.filter-type12').val();
        var filter_start = $('.filter-start12').val();
        var filter_end = $('.filter-end12').val();
        var game = $('.filter-game12').val();
        var userId = $('.filter-user12').val();
        var optionLoop = '';

        // var userId = $(this).attr("data-userId");
        // var game = $(this).attr("data-game");
        // console.log(userId,game)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "POST";
        var ajaxurl = '/filter-undo-history';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {
                "filter_type": filter_type,
                "userId": userId,
                "game": game,
                "filter_start": filter_start,
                "filter_end": filter_end,
                "historyType": historyType,
            },
            dataType: 'json',
            beforeSend: function() {
                $(".undo-history-body123").html('Loading...');
            },
            success: function(data) {
                if(data.status == 0){
                    
                    optionLoop = '<tr><td>No Transaction</td></tr>';

                }else{
                    (data.data).forEach(function(index) {
                        var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        
                        var date_format = new Date(index.created_at);
                        // FB NAME	GAME	GAME ID	AMOOUNT	TYPE	CREATED BY	ACTION BY
                        var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        optionLoop +=
                            '<tr><td class="text-center">' + a + 
                            '</td><td class="text-center">' + index.form.facebook_name + 
                            '</td><td class="text-center">' + index.account.name + 
                            '</td><td class="text-center">' + index.form_games.game_id + 
                            '</td><td class="text-center">' + index.amount_loaded + 
                            '</td><td class="text-center">' + ((index.type == 'refer')?'bonus':index.type)  + 
                            '</td><td class="text-center">' + index.created_by.name + 
                            '</td><td class="text-center"><a href="/undo-table/' + index.id + 
                            '" class="btn btn-primary">Undo</a></td></tr>';
                    });
                }
                // if (typeof data !== 'undefined' && data.length > 0) {
                    
                // }else{
                // }
           $(".undo-history-body123").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
        console.log(filter_type);
        console.log(filter_start);
        console.log(filter_end);
    });
    $('.filter-history').on('click', function(e) {
        e.stopImmediatePropagation();
        console.log('a');
        var historyType = '';
        if ($(this).hasClass('form-all')) {
            historyType = 1;
            var filter_type = $('.filter-type1').val();
            var filter_start = $('.filter-start1').val();
            var filter_end = $('.filter-end1').val();
        } else {
            var filter_type = $('.filter-type').val();
            var filter_start = $('.filter-start').val();
            var filter_end = $('.filter-end').val();
        }

        var userId = $(this).attr("data-userId");
        var game = $(this).attr("data-game");
        // console.log(userId,game)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "POST";
        var ajaxurl = '/filter-user-history';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {
                "filter_type": filter_type,
                "userId": userId,
                "game": game,
                "filter_start": filter_start,
                "filter_end": filter_end,
                "historyType": historyType,
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                // console.log(data);

                $('.total-tip').text(0);
                $('.total-balance').text(0);
                $('.total-redeem').text(0);
                $('.total-refer').text(0);
                $('.total-amount').text(0);
                $('.total-profit').text(0);
                if (data[0] != '') {
                    optionLoop = '';
                    options = data[0];
                    var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    if (historyType == '') {
                        options.forEach(function(index) {
                            var date_format = new Date(index.created_at);
                            var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                            optionLoop +=
                                '<tr><td class="text-center">' + a + '</td><td class="text-center"><span class="badge  bg-gradient-success"> ' + index.amount_loaded + '$</span></td><td class="text-center">'
                                + ((index.type == 'refer')?'bonus':index.type)  + '</td><td class="text-center">' + index.created_by.name + '</td></tr>';
                        });
                        `    `
                        // console.log('yhere');
                    } else {
                        console.log(data[1].tip);
                        $('.total-tip').text(data[1].tip);
                        $('.total-balance').text(data[1].load);
                        $('.total-redeem').text(data[1].redeem);
                        $('.total-refer').text(data[1].refer);
                        $('.total-amount').text(data[1].cashAppLoad);
                        $('.total-profit').text(data[1].profit);
                        options.forEach(function(index) {
                            var date_format = new Date(index.created_at);
                            var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                            optionLoop +=
                                '<tr><td class="text-center">' + a + '</td><td class="text-center">' + index.account.name + '</td><td class="text-center"><span class="badge  bg-gradient-success"> ' + index.amount_loaded + '$</span></td><td class="text-center">'
                                + ((index.type == 'refer')?'bonus':index.type)  + '</td><td class="text-center">' + index.created_by.name + '</td></tr>';
                        });
                    }

                } else {
                    optionLoop = '<tr><td>No History</td></tr>';
                }
                $(".user-history-body").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
        console.log(filter_type);
        console.log(filter_start);
        console.log(filter_end);
    });

    $('.export-file').on('click', function(e) {
        var filter_type = $('.filter-type12').val();
        var filter_start = $('.filter-start12').val();
        var filter_end = $('.filter-end12').val();
        var filter_game = $('.filter-game12').val();
        var filter_user = $('.filter-user12').val();

        // window.location.replace('/exportcsv?game=' + gameTitle);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "POST";
        var ajaxurl = '/export';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {
                "filter_type": filter_type,
                "filter_start": filter_start,
                "filter_end": filter_end,
                "filter_game": filter_game,
                "filter_user": filter_user,
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                // if (data != 'success') {
                //     toastr.error('Error', data.responseText);
                // }
                console.log('hiddenElement');
                var csv = 'SN;Date;FB Name;Game;Game-ID;Amount;Type;Creator\n';
                //merge the data with CSV
                data[0].forEach(function(row) {
                    csv += row.join(';');
                    csv += "\n";
                });
                data[1].forEach(function(row) {
                    csv += row.join(';');
                    csv += "\n";
                });

                //display the created CSV data on the web browser
                // document.write(csv);
                var hiddenElement = document.createElement('a');
                hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
                hiddenElement.target = '_blank';
                hiddenElement.download = 'file.csv';
                hiddenElement.click();
                toastr.success('Success', 'File Exported');

                // var csvFile = new Blob([csv], { type: "text/csv" });
                // downloadLink = targetWind.document.createElement("a");
                // downloadLink.download = 'file.csv';
                // downloadLink.href = targetWind.URL.createObjectURL(csvFile);
                // downloadLink.style.display = "none";
                // targetWind.document.body.appendChild(downloadLink);
                // downloadLink.click();

                console.log(hiddenElement);
            },
            error: function(data) {
                console.log('eee');
                //define the heading for each row of the data
                var csv = 'SN;Date;FB Name;Game;Game ID;Amount;Type;Creator\n';
                //merge the data with CSV
                data.forEach(function(row) {
                    console.log(row);
                    csv += row;
                    csv += ";";
                });

                //display the created CSV data on the web browser
                document.write(csv);
                var hiddenElement = document.createElement('a');
                hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
                hiddenElement.target = '_blank';

                //provide the name for the CSV file to be downloaded
                hiddenElement.download = 'file.csv';
                hiddenElement.click();




                // var downloadLink = document.createElement("a");
                // var fileData = ['\ufeff'+data];

                // var blobObject = new Blob(fileData,{
                //    type: "text/csv;charset=utf-8;"
                //  });

                // var url = URL.createObjectURL(blobObject);
                // downloadLink.href = url;
                // downloadLink.download = "products.csv";

                // /*
                //  * Actually download CSV
                //  */
                // document.body.appendChild(downloadLink);
                // downloadLink.click();
                // document.body.removeChild(downloadLink);
                toastr.success('Success', 'File Exported');
                // toastr.error('Error', data.responseText);
            }
        });
        console.log(filter_type);
        console.log(filter_start);
        console.log(filter_end);
    });
    $('.filter-all-history').on('click', function(e) {
        var filter_type = $('.filter-type12').val();
        var filter_start = $('.filter-start12').val();
        var filter_end = $('.filter-end12').val();
        var filter_game = $('.filter-game12').val();
        var filter_user = $('.filter-user12').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "POST";
        var ajaxurl = '/filter-all-history';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {
                "filter_type": filter_type,
                "filter_start": filter_start,
                "filter_end": filter_end,
                "filter_game": filter_game,
                "filter_user": filter_user,
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                console.log(data[0]);
                if (data != '') {
                    optionLoop = '';
                    options = data[0];
                    var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    var count = 1;
                    options.forEach(function(index) {
                        if (index.form.facebook_name === undefined || index.form.facebook_name === null) {
                            var facebook_name = 'Empty'
                        } else {
                            var facebook_name = index.form.facebook_name;
                        }
                        var date_format = new Date(index.created_at);
                        var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        optionLoop +=
                        '<tr><td class="align-middle text-center "><div class="d-flex px-2 py-1"><div class="d-flex flex-column justify-content-center"><h6 class=" mb-0 text-sm">'+ (count++) + '</h6></div></div></td><td class="align-middle text-center "><div class="d-flex px-2 py-1"><div class="d-flex flex-column justify-content-center"><h6 class=" mb-0 text-sm">'+ (facebook_name) + '</h6></div></div></td><td class="align-middle text-center "><div class="d-flex px-2 py-1"><div class="d-flex flex-column justify-content-center"><h6 class=" mb-0 text-sm">'+ (index.account.name) + '</h6></div></div></td><td class="align-middle text-center "><div class="d-flex px-2 py-1"><div class="d-flex flex-column justify-content-center"><h6 class=" mb-0 text-sm">'+ (index.form_game.game_id) + '</h6></div></div></td><td class="align-middle text-center "><span class="badge  bg-gradient-success">'+ (index.amount_loaded) + '</span></td><td class="align-middle text-center "><div class="d-flex px-2 py-1"><div class="d-flex flex-column justify-content-center"><h6 class=" mb-0 text-sm">'+ (((index.type == 'refer')?'bonus':index.type)) + '</h6></div></div></td><td><h6 class=" mb-0 text-sm">'+a+'</h6></td></tr>'
                            // '<tr><td class="text-center">' + (count++) + '</td><td class="text-center">' + a + '</td><td class="text-center">' + facebook_name + '</td><td class="text-center">' + index.account.name + '</td><td class="text-center">' + index.form_game.game_id + '</td><td class="text-center">$ ' + index.amount_loaded + '</td><td class="text-center">' + ((index.type == 'refer')?'bonus':index.type)  + '</td><td class="text-center">' + index.created_by.name + '</td></tr>';
                    });

                    console.log(data[1]);
                    $('.total-tip').text('$'+data[1].tip);
                    $('.total-balance').text('$'+data[1].load);
                    $('.total-redeem').text('+'+data[1].redeem);
                    $('.total-refer').text('$'+data[1].refer);
                    $('.total-amount').text('+'+data[1].cashAppLoad);
                    $('.total-profit').text('$'+data[1].profit);
                    if ($('.datatable').length > 0) {
                        $('.datatable').DataTable().destroy();
                        // $('.datatable').DataTable().clear();
                        $('.datatable').DataTable({
                            pageLength: 100,
                            dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                            buttons: [{
                                    extend: 'copy',
                                    className: 'btn-sm btn-info',
                                    title: 'Gamers',
                                    header: false,
                                    footer: true,
                                    exportOptions: {
                                        // columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-sm btn-success',
                                    title: 'Gamers',
                                    header: false,
                                    footer: true,
                                    exportOptions: {
                                        // columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'excel',
                                    className: 'btn-sm btn-warning',
                                    title: 'Gamers',
                                    header: false,
                                    footer: true,
                                    exportOptions: {
                                        // columns: ':visible',
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    className: 'btn-sm btn-primary',
                                    title: 'Gamers',
                                    pageSize: 'A2',
                                    header: false,
                                    footer: true,
                                    exportOptions: {
                                        // columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'print',
                                    className: 'btn-sm btn-success',
                                    title: 'Gamers',
                                    // orientation:'landscape',
                                    pageSize: 'A2',
                                    header: true,
                                    footer: false,
                                    orientation: 'landscape',
                                    exportOptions: {
                                        // columns: ':visible',
                                        stripHtml: false
                                    }
                                }
                            ],
                        });
                    }

                } else {
                    optionLoop = '<tr><td>No History</td></tr>';
                }
                $(".user-history-body").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
        // console.log(filter_type);
        // console.log(filter_start);
        // console.log(filter_end);
    });
    $('#form-game-change').on('change', function(e) {
        var gameId = $(this).find(':selected').data('id');
        $(".game-id-option").each(function(i){
            if($(this).val() == gameId){
                $(this).attr('selected','selected');
            }else{
                var attr = $(this).attr('selected');
                if (typeof attr !== 'undefined' && attr !== false) {
                    $(this).removeAttr('selected');
                }
            }
        });
    });
    $('.user-full-history').on('click', function(e) {
        // $('#exampleModalCenter5').modal('show');
        // if(!($('.form-history-related').hasClass('hidden'))){
        //   $('.form-history-related').addClass('hidden')
        // }
        var type = [];
        var userId = $(this).attr("data-userId");
        var game = $(this).attr("data-game");
        var gameId = $(this).attr("data-gameId");
        $('.user-name').text(gameId);
        $('.filter-history').attr("data-userId", userId);
        $('.filter-history').attr("data-game", game);
        $('.history-type-change-btn').attr("data-userId", userId);
        $('.history-type-change-btn').attr("data-game", game);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "POST";
        var ajaxurl = '/user-history';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {
                "type": type,
                "userId": userId,
                "game": game,
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                if (data != '') {
                    optionLoop = '';
                    options = data;
                    var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    options.forEach(function(index) {
                        var date_format = new Date(index.created_at);
                        var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        optionLoop +=
                            '<tr><td class="text-center">' + a + '</td><td class="text-center"><span class="badge  bg-gradient-success"> ' + index.amount_loaded + '$</span></td><td class="text-center">' + ((index.type == 'refer')?'bonus':index.type)  + '</td><td class="text-center">' + index.created_by.name + '</td></tr>';
                    });
                } else {
                    optionLoop = '<tr><td>No History</td></tr>';
                }
                $(".user-history-body").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
    });
    $('.form-full-history').on('click', function(e) {
        // $('#exampleModalCenter6').modal('show');

        // if($('.form-history-related').hasClass('hidden')){
        //   $('.form-history-related').removeClass('hidden')
        // }

        var type = [];
        var userId = $(this).attr("data-userId");
        var game = $(this).attr("data-game");

        var gameId = $(this).attr("data-gameId");
        $('.user-name').text(gameId);

        $('.filter-history').attr("data-userId", userId);
        $('.filter-history').attr("data-game", game);
        $('.history-type-change-btn').attr("data-userId", userId);
        $('.history-type-change-btn').attr("data-game", game);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "POST";
        var ajaxurl = '/user-history';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {
                "type": type,
                "userId": userId,
                "game": game,
                "getType": 'all',
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {


                $('.total-tip').text(0);
                $('.total-balance').text(0);
                $('.total-redeem').text(0);
                $('.total-refer').text(0);
                $('.total-amount').text(0);
                $('.total-profit').text(0);
                if (data[0] != '') {
                    optionLoop = '';
                    options = data[0];

                    $('.total-tip').text(data[1].tip);
                    $('.total-balance').text(data[1].load);
                    $('.total-redeem').text(data[1].redeem);
                    $('.total-refer').text(data[1].refer);
                    $('.total-amount').text(data[1].cashAppLoad);
                    $('.total-profit').text(data[1].profit);
                    var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    options.forEach(function(index) {
                        var date_format = new Date(index.created_at);
                        var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        optionLoop +=
                            '<tr><td class="text-center">' + a
                            + '</td><td class="text-center">'
                            + index.account.name
                            + '</td><td class="text-center"><span class="badge  bg-gradient-success"> '
                            + index.amount_loaded
                            + '$</span></td><td class="text-center">'
                            + ((index.type == 'refer')?'bonus':index.type)
                            + '</td><td class="text-center">'
                            + index.created_by.name
                            + '</td></tr>';
                    });
                } else {
                    optionLoop = '<tr><td>No History</td></tr>';
                }
                $(".user-history-body").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
    });
    $('.all-history').on('click', function(e) {
        $('#exampleModalCenter7').modal('show');

        // if($('.form-history-related').hasClass('hidden')){
        //   $('.form-history-related').removeClass('hidden')
        // }

        // $('.filter-history').attr("data-userId",userId);
        // $('.filter-history').attr("data-game",game);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "GET";
        var ajaxurl = '/all-history';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {},
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                if (data != '') {
                    optionLoop = '';
                    options = data;
                    var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    options.forEach(function(index) {
                        var date_format = new Date(index.created_at);
                        var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        // console.log(index);
                        if (index.form.facebook_name === undefined || index.form.facebook_name === null) {
                            var facebook_name = 'Empty'
                        } else {
                            var facebook_name = index.form.facebook_name;
                        }

                        optionLoop +=
                            '<tr><td class="text-center">' + a + '</td><td class="text-center">' + facebook_name + '</td><td class="text-center">' + index.account.name + '</td><td class="text-center">' + index.form_game.game_id + '</td><td class="text-center">$ ' + index.amount_loaded + '</td><td class="text-center">' + ((index.type == 'refer')?'bonus':index.type)  + '</td><td class="text-center">' + index.created_by.name + '</td></tr>';
                    });
                } else {
                    optionLoop = '<tr><td>No History</td></tr>';
                }
                $(".user-history-body").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
    });
    $('.undo-transaction').on('click', function(e) {
        // $('#exampleModalCenter8').modal('show');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "GET";
        var ajaxurl = '/undo-history';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {},
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                if (data != '') {
                    optionLoop = '';
                    options = data;
                    var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    options.forEach(function(index) {
                        var date_format = new Date(index.created_at);
                        var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        // console.log(index);
                        if (index.form.facebook_name === undefined || index.form.facebook_name === null) {
                            var facebook_name = 'Empty'
                        } else {
                            var facebook_name = index.form.facebook_name;
                        }

                        optionLoop +=
                            '<tr><td class="text-center">' + a + '</td><td class="text-center">' + facebook_name + '</td><td class="text-center">' + index.account.name + '</td><td class="text-center">' + index.form_game.game_id + '</td><td class="text-center">$ ' + index.amount_loaded + '</td><td class="text-center">' + ((index.type == 'refer')?'bonus':index.type)  + '</td><td class="text-center">' + ((index.created_by.name != '')?index.created_by.name:'')  + '</td><td class="text-center"><button class="btn btn-primary undo-this" data-id="'+index.id+'" data-gameid="'+index.account.id+'">Undo</button></td></tr>';
                    });
                } else {
                    optionLoop = '<tr><td>No History</td></tr>';
                }
                $(".undo-history-body").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
        undoFunction();
    });
    
    function undoFunction(){
        $(document).off().on('click', '.undo-this', function(event) {
            var cid = $(this).data('id');
            var gid = $(this).data('gameid');
            $(this).attr('disabled','disabled');
            console.log(cid);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            var actionType = "GET";
            var ajaxurl = '/undo-item-history/'+cid;
            $.ajax({
                type: actionType,
                url: ajaxurl,
                data: {},
                dataType: 'json',
                beforeSend: function() {
                    // $(".undo-history-body123").html('Loading...');
                },
                success: function(data) {
                    if (!(data.success === undefined || data.success === null)) {                        
                        if(data.success.type != 'tip'){
                            
                            $('.game-card-'+gid+' .game-btn').removeAttr('data-balance');
                            $('.game-card-'+gid+' .game-btn').attr('data-balance',data.success.newAmount);
                            $('.game-card-'+gid+' .game-span-item').html('$ '+data.success.newAmount);
                        }
                        toastr.success('Success','Undo Successful');
                        $('.item-'+cid).remove();
                    }
                    console.log(data.success);
    
                },
                error: function(data) {
                    $(this).removeAttr('disabled');
                    toastr.error('Error', data.responseText);
                }
            });
        })
    }
    function clearBtns(){
        $('.thisBtn').each(function( index ){
            $(this).removeClass();
            $(this).addClass('btn btn-success thisBtn text-center');
        });
    }
    $(function() {
        $('.referInput').on('keydown', function(e) {
            var userCashAppBtn = $(".user-refer-" + $(this).attr('data-user'));
            var userCashAppCollapse = userCashAppBtn.attr('data-target');


            if (e.which == 9) {
                $(userCashAppCollapse).collapse('hide');

                var nextBtn = $(".user-redeem-" + $(this).attr('data-user'));
                console.log(nextBtn);
                var nextCollapse = nextBtn.attr('data-target');
                $(nextCollapse).collapse('show');

                // console.log($(".user-" + $(this).attr('data-user')).attr('data-target'));
                // $(".user-" + $(this).attr('data-user')).attr('data-target').nextCollapse('show');
                // attr('data-target').collapse('show')
            }
            if (e.which === 13) {
                $(this).attr('disabled','disabled');
                if (($(this).val()) == '' || $(this).val() < 0) {
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(this).parent().find(".refer-from").attr("data-title");
                var gameId = $(this).parent().find('.refer-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userid');
                var userBalanceBtn = $(".user-" + $(this).attr('data-user'));
                var useReferBtn = $(".user-refer-" + $(this).attr('data-user'));
                var userCashAppCollapse = useReferBtn.attr('data-target');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(useReferBtn.attr('data-balance'));

                var amount = parseInt($(this).val());

                if (amount > currentGameBalance) {
                    $(this).removeAttr('disabled');
                    toastr.error('Balance to load is greater than the game balance.');
                    return;
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var type = "POST";
                    var ajaxurl = '/table-referBalance';
                    var interval = null;
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        data: {
                            "gameId": gameId,
                            "userId": userId,
                            "amount": amount,
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            i = 0;
                            $(".load-btn").addClass("disabled");
                            interval = setInterval(function() {
                                i = ++i % 4;
                                $(".load-btn").html("Loading Balance" + Array(i + 1).join("."));
                            }, 300);
                        },
                        success: function(data) {
                            $('.referInput').removeAttr('disabled');
                            clearInterval(interval);

                            $(userCashAppCollapse).collapse('hide');

                            var totalGameBalance = currentGameBalance - amount;
                            var totalUserBalance = amount + currentUserBalance;

                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");

                            // userBalanceBtn.attr('data-balance',totalUserBalance);
                            // userBalanceBtn.text('$ '+totalUserBalance);


                            useReferBtn.attr('data-balance', totalUserBalance);
                            useReferBtn.text('$ ' + totalUserBalance);

                            gameBtn.attr('data-balance', totalGameBalance);

                            $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                            // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                            amount = 0;
                            currentGameBalance = 0;
                            currentUserBalance = 0;

                            $('#exampleModalCenter').modal('hide');
                            toastr.success('Balance Referred to User : ' + user);

                            $('.amount').val('');
                            $('.referInput').val('');
                            // optionLoop = '';
                            // options = data;
                            // options.forEach(function(index) {
                            //   optionLoop +=
                            //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                            // });
                            // $(".load-from").html(optionLoop);

                        },
                        error: function(data) {
                            $('.referInput').removeAttr('disabled');
                            clearInterval(interval);
                            $(".refer-btn").removeClass("disabled");
                            $(".refer-btn").html("Load");
                            toastr.error('Error', data.responseText);
                            console.log('error in referring balance');
                        }
                    });
                }
            }
        });
    });
     $(function() {
        $('.refer-btn').on('click', function(e) {
            // var userCashAppBtn = $(".user-refer-" + $('.referInput'+$(this).attr('data-userId')).attr('data-user'));
            // var userCashAppCollapse = userCashAppBtn.attr('data-target');
            // Assuming you're inside an event handler function
            var dataUserId = $(this).attr('data-userId'); // Assuming 'this' refers to the element you want to target
            
            // Constructing the selector to target elements with the class '.referInput' and the appropriate 'data-userId' attribute
            var selector = '.referInput[data-userId="' + dataUserId + '"]';
            
            // Selecting the desired element using the constructed selector
            var userCashAppBtn = $(".user-refer-" + $(selector).attr('data-user'));
            
            // Accessing the 'data-target' attribute of the selected element
            var userCashAppCollapse = userCashAppBtn.attr('data-target');
            $('.referInput'+$(this).attr('data-userId')).attr('disabled','disabled');
                // if (($('.referInput'+$(this).attr('data-userId')).val()) == '' || $('.referInput'+$('.referInput'+$(this).attr('data-userId')).val() < 0) 
                //     {
                //         toastr.error('Please enter a valid amount.');
                //         return;
                //     }
                if ($('.referInput' + $(this).attr('data-userId')).val() === '' || parseFloat($('.referInput' + $(this).attr('data-userId')).val()) < 0) {
                    toastr.error('Please enter a valid amount.');
                    return;
                }

                var gameTitle = $(this).attr("data-title");
                var gameId = $(this).parent().find('.refer-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId =$(this).attr('data-userId');
               
                var userBalanceBtn = $(".user-" + $('.referInput'+$(this).attr('data-userId')).attr('data-user'));
                var useReferBtn = $(".user-refer-" + $('.referInput'+$(this).data('userId')).attr('data-user'));
                var userCashAppCollapse = useReferBtn.attr('data-target');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(useReferBtn.attr('data-balance'));

                var amount = parseInt($('.referInput'+$(this).attr('data-userId')).val());

                if (amount > currentGameBalance) {
                    $(this).removeAttr('disabled');
                    toastr.error('Balance to load is greater than the game balance.');
                    return;
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var type = "POST";
                    var ajaxurl = '/table-referBalance';
                    var interval = null;
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        data: {
                            "gameId": gameId,
                            "userId": userId,
                            "amount": amount,
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            i = 0;
                            $(".load-btn").addClass("disabled");
                            interval = setInterval(function() {
                                i = ++i % 4;
                                $(".load-btn").html("Loading Balance" + Array(i + 1).join("."));
                            }, 300);
                        },
                        success: function(data) {
                            $('.referInput').removeAttr('disabled');
                            clearInterval(interval);

                            $(userCashAppCollapse).collapse('hide');

                            var totalGameBalance = currentGameBalance - amount;
                            var totalUserBalance = amount + currentUserBalance;

                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");

                            // userBalanceBtn.attr('data-balance',totalUserBalance);
                            // userBalanceBtn.text('$ '+totalUserBalance);


                            useReferBtn.attr('data-balance', totalUserBalance);
                            useReferBtn.text('$ ' + totalUserBalance);

                            gameBtn.attr('data-balance', totalGameBalance);

                            $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                            // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                            amount = 0;
                            currentGameBalance = 0;
                            currentUserBalance = 0;

                            $('#exampleModalCenter').modal('hide');
                            toastr.success('Balance Referred to User : ' + user);

                            $('.amount').val('');
                            $('.referInput').val('');
                            // optionLoop = '';
                            // options = data;
                            // options.forEach(function(index) {
                            //   optionLoop +=
                            //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                            // });
                            // $(".load-from").html(optionLoop);

                        },
                        error: function(data) {
                            $('.referInput').removeAttr('disabled');
                            clearInterval(interval);
                            $(".refer-btn").removeClass("disabled");
                            $(".refer-btn").html("Load");
                            toastr.error('Error', data.responseText);
                            console.log('error in referring balance');
                        }
                    });
                }
        });
    });
    
    
    $(function() {
        $('.referInput').on('touchstart', function(e) {
            var userCashAppBtn = $(".user-refer-" + $(this).attr('data-user'));
            var userCashAppCollapse = userCashAppBtn.attr('data-target');


            if (e.which == 9) {
                $(userCashAppCollapse).collapse('hide');

                var nextBtn = $(".user-redeem-" + $(this).attr('data-user'));
                console.log(nextBtn);
                var nextCollapse = nextBtn.attr('data-target');
                $(nextCollapse).collapse('show');

                // console.log($(".user-" + $(this).attr('data-user')).attr('data-target'));
                // $(".user-" + $(this).attr('data-user')).attr('data-target').nextCollapse('show');
                // attr('data-target').collapse('show')
            }
            if (e.which === 13) {
                $(this).attr('disabled','disabled');
                if (($(this).val()) == '' || $(this).val() < 0) {
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(this).parent().find(".refer-from").attr("data-title");
                var gameId = $(this).parent().find('.refer-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userid');
                var userBalanceBtn = $(".user-" + $(this).attr('data-user'));
                var useReferBtn = $(".user-refer-" + $(this).attr('data-user'));
                var userCashAppCollapse = useReferBtn.attr('data-target');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(useReferBtn.attr('data-balance'));

                var amount = parseInt($(this).val());

                if (amount > currentGameBalance) {
                    $(this).removeAttr('disabled');
                    toastr.error('Balance to load is greater than the game balance.');
                    return;
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var type = "POST";
                    var ajaxurl = '/table-referBalance';
                    var interval = null;
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        data: {
                            "gameId": gameId,
                            "userId": userId,
                            "amount": amount,
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            i = 0;
                            $(".load-btn").addClass("disabled");
                            interval = setInterval(function() {
                                i = ++i % 4;
                                $(".load-btn").html("Loading Balance" + Array(i + 1).join("."));
                            }, 300);
                        },
                        success: function(data) {
                            $('.referInput').removeAttr('disabled');
                            clearInterval(interval);

                            $(userCashAppCollapse).collapse('hide');

                            var totalGameBalance = currentGameBalance - amount;
                            var totalUserBalance = amount + currentUserBalance;

                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");

                            // userBalanceBtn.attr('data-balance',totalUserBalance);
                            // userBalanceBtn.text('$ '+totalUserBalance);


                            useReferBtn.attr('data-balance', totalUserBalance);
                            useReferBtn.text('$ ' + totalUserBalance);

                            gameBtn.attr('data-balance', totalGameBalance);

                            $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                            // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                            amount = 0;
                            currentGameBalance = 0;
                            currentUserBalance = 0;

                            $('#exampleModalCenter').modal('hide');
                            toastr.success('Balance Referred to User : ' + user);

                            $('.amount').val('');
                            $('.referInput').val('');
                            // optionLoop = '';
                            // options = data;
                            // options.forEach(function(index) {
                            //   optionLoop +=
                            //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                            // });
                            // $(".load-from").html(optionLoop);

                        },
                        error: function(data) {
                            $('.referInput').removeAttr('disabled');
                            clearInterval(interval);
                            $(".refer-btn").removeClass("disabled");
                            $(".refer-btn").html("Load");
                            toastr.error('Error', data.responseText);
                            console.log('error in referring balance');
                        }
                    });
                }
            }
        });
    });
    function referBtnClickEvent(){
        $(function() {
            $('body').on('click', ".refer-btn", function(e) {
            // $(document).on('click','.refer-btn', function(e) {
                e.stopImmediatePropagation();
                var referInput = $('.referInput'+$(this).attr('data-userid'));
                if ((referInput) == '' || parseInt(referInput) < 0) {
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $('.loadFrom'+$(this).attr('data-userid')).attr("data-title");
                var gameId = $('.loadFrom'+$(this).attr('data-userid')).val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userid');
                var userBalanceBtn = $(".user-" + $(this).attr('data-user'));
                var useReferBtn = $(".user-refer-" + $(this).attr('data-user'));
                var userCashAppCollapse = useReferBtn.attr('data-target');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(useReferBtn.attr('data-balance'));

                var amount = parseInt(referInput.val());

                if (amount > currentGameBalance) {
                    toastr.error('Balance to load is greater than the game balance.');
                    return;
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var type = "POST";
                    var ajaxurl = '/table-referBalance';
                    var interval = null;
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        data: {
                            "gameId": gameId,
                            "userId": userId,
                            "amount": amount,
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            i = 0;
                            $(".refer-btn").addClass("disabled");
                            interval = setInterval(function() {
                                i = ++i % 4;
                                $(".refer-btn").html("Loading Balance" + Array(i + 1).join("."));
                            }, 300);
                        },
                        success: function(data) {
                            clearInterval(interval);

                            $(userCashAppCollapse).collapse('hide');

                            var totalGameBalance = currentGameBalance - amount;
                            var totalUserBalance = amount + currentUserBalance;

                            $(".refer-btn").removeClass("disabled");
                            $(".refer-btn").html("Load");

                            // userBalanceBtn.attr('data-balance',totalUserBalance);
                            // userBalanceBtn.text('$ '+totalUserBalance);


                            useReferBtn.attr('data-balance', totalUserBalance);
                            useReferBtn.text('$ ' + totalUserBalance);

                            gameBtn.attr('data-balance', totalGameBalance);
                            $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                            // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                            amount = 0;
                            currentGameBalance = 0;
                            currentUserBalance = 0;

                            $('#exampleModalCenter').modal('hide');
                            toastr.success('Balance Referred to User : ' + user);

                            $('.amount').val('');
                            clearBtns();

                            $( ".refer-btn" ).off("click");
                            // optionLoop = '';
                            // options = data;
                            // options.forEach(function(index) {
                            //   optionLoop +=
                            //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                            // });
                            // $(".load-from").html(optionLoop);

                        },
                        error: function(data) {
                            clearInterval(interval);
                            $(".refer-btn").removeClass("disabled");
                            $(".refer-btn").html("Load");
                            toastr.error('Error', data.responseText);
                            console.log('error in referring balance');
                        }
                    });
                }
            });
        });
    }
    $(function() {
        $('.amount').on('keydown', function(e) {
            var userCashAppBtn = $(".user-cashapp-" + $(this).attr('data-user'));
            var userCashAppCollapse = userCashAppBtn.attr('data-target');


            if (e.which == 9) {
                $(userCashAppCollapse).collapse('hide');

                var nextBtn = $(".user-" + $(this).attr('data-user'));
                var nextCollapse = nextBtn.attr('data-target');
                $(nextCollapse).collapse('show');

                // console.log($(".user-" + $(this).attr('data-user')).attr('data-target'));
                // $(".user-" + $(this).attr('data-user')).attr('data-target').nextCollapse('show');
                // attr('data-target').collapse('show')
            }
            if (e.which === 13) {
                console.log('form submitted');
                if (($(this).val()) == '' || $(this).val() < 0) {
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var cashAppId = $(".cash-app-btn").attr("data-id");
                var cashAppTitle = $(".cash-app-btn").attr("data-title");
                var cashAppBalance = $(".cash-app-btn").attr("data-balance");

                var cashAppBtn = $(".cash-app-btn");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userid');

                var currentCashAppBalance = parseInt(cashAppBalance);
                var currentUserBalance = parseInt(userCashAppBtn.attr('data-balance'));

                var gameId = $(this).parent().find('.cashApp-from').val();

                var amount = parseInt($(this).val());
                
               

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var type = "POST";
                var ajaxurl = '/table-loadCashBalance';
                var interval = null;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: {
                        "cashAppId": cashAppId,
                        "userId": userId,
                        "amount": amount,
                        "gameId": gameId,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        i = 0;
                        $(".cashApp-btn").addClass("disabled");
                        interval = setInterval(function() {
                            i = ++i % 4;
                            $(".cashApp-btn").html("Loading Balance" + Array(i + 1).join("."));
                        }, 300);
                    },
                    success: function(data) {
                        clearInterval(interval);
                        $(userCashAppCollapse).collapse('hide');

                        var totalCashAppBalance = currentCashAppBalance + amount;
                        var totalUserBalance = amount + currentUserBalance;

                        $(".cashApp-btn").removeClass("disabled");
                        $(".cashApp-btn").html("Load");

                        cashAppBtn.attr('data-balance', totalCashAppBalance);
                        cashAppBtn.text('Cash App Acccount : ' + cashAppTitle + ': $ ' + totalCashAppBalance);


                        userCashAppBtn.attr('data-balance', totalUserBalance);
                        userCashAppBtn.text('$ ' + totalUserBalance);

                        // gameBtn.attr('data-balance',totalGameBalance);
                        // gameBtn.text(gameTitle.replace("-", " ") + ' : ' +totalGameBalance);

                        // subtract amount from cash app

                        amount = 0;
                        currentGameBalance = 0;
                        currentUserBalance = 0;

                        // $('#exampleModalCenter').modal('hide');
                        toastr.success('Balance Loaded to User : ' + user + ' from cashapp.');

                        $('.amount').val('');
                        // optionLoop = '';
                        // options = data;
                        // options.forEach(function(index) {
                        //   optionLoop +=
                        //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                        // });
                        // $(".load-from").html(optionLoop);

                    },
                    error: function(data) {
                        alert(data.responseText);
                        clearInterval(interval);
                        $(".cashApp-btn").removeClass("disabled");
                        $(".cashApp-btn").html("Load");
                        toastr.error('Error', data.responseText);
                        console.log('error in loading balance from cashapp.');
                    }
                });
            }
        });
    });
    $(function() {
        $('.cashApp-btn').on('click', function(e) {
            if (($(this).parent().find('.amount').val()) == '' || parseInt($(this).parent().find('.amount').val()) < 0) {
                toastr.error('Please enter a valid amount.');
                return;
            }
            var cashAppId = $(".cash-app-btn").attr("data-id");
            var cashAppTitle = $(".cash-app-btn").attr("data-title");
            var cashAppBalance = $(".cash-app-btn").attr("data-balance");

            var cashAppBtn = $(".cash-app-btn");

            var user = $(this).attr('data-user');
            var userId = $(this).attr('data-userid'); //form id
            var userCashAppBtn = $(".user-cashapp-" + $(this).attr('data-user'));
            var userCashAppCollapse = userCashAppBtn.attr('data-target');
            // var useReferBtn = $(".user-cashapp-"+$(this).attr('data-user'));

            var currentCashAppBalance = parseInt(cashAppBalance);
            var currentUserBalance = parseInt(userCashAppBtn.attr('data-balance'));

            // var cashAppId = $(this).attr('data-cashApp');
            var gameId = $(this).parent().find('.cashApp-from').val();



            var amount = parseInt($(this).parent().find('.amount').val());

            // if(amount > currentGameBalance){
            //   toastr.error('Balance to load is greater than the game balance.');
            //   return;
            // }else{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            var type = "POST";
            var ajaxurl = '/table-loadCashBalance';
            var interval = null;
            $.ajax({
                type: type,
                url: ajaxurl,
                data: {
                    "cashAppId": cashAppId,
                    "userId": userId,
                    "amount": amount,
                    "gameId": gameId,
                },
                dataType: 'json',
                beforeSend: function() {
                    i = 0;
                    $(".cashApp-btn").addClass("disabled");
                    interval = setInterval(function() {
                        i = ++i % 4;
                        $(".cashApp-btn").html("Loading Balance" + Array(i + 1).join("."));
                    }, 300);
                },
                success: function(data) {
                    clearInterval(interval);
                    $(userCashAppCollapse).collapse('hide');

                    var totalCashAppBalance = currentCashAppBalance + amount;
                    var totalUserBalance = amount + currentUserBalance;

                    $(".cashApp-btn").removeClass("disabled");
                    $(".cashApp-btn").html("Load");

                    cashAppBtn.attr('data-balance', totalCashAppBalance);
                    cashAppBtn.text('Cash App Acccount : ' + cashAppTitle + ': $ ' + totalCashAppBalance);


                    userCashAppBtn.attr('data-balance', totalUserBalance);
                    userCashAppBtn.text('$ ' + totalUserBalance);

                    // gameBtn.attr('data-balance',totalGameBalance);
                    // gameBtn.text(gameTitle.replace("-", " ") + ' : ' +totalGameBalance);

                    // subtract amount from cash app

                    amount = 0;
                    currentGameBalance = 0;
                    currentUserBalance = 0;

                    // $('#exampleModalCenter').modal('hide');
                    toastr.success('Balance Loaded to User : ' + user + ' from cashapp.');

                    $('.amount').val('');
                    // optionLoop = '';
                    // options = data;
                    // options.forEach(function(index) {
                    //   optionLoop +=
                    //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                    // });
                    // $(".load-from").html(optionLoop);

                },
                error: function(data) {
                    clearInterval(interval);
                    $(".cashApp-btn").removeClass("disabled");
                    $(".cashApp-btn").html("Load");
                    toastr.error('Error', data.responseText);
                    console.log('error in loading balance from cashapp.');
                }
            });
            // }
        });
    });
    $(function() {
        $('.resetThis').on('click', function(e) {
            var userCashAppBtn = $(".user-" + $(this).attr('data-user'));
            var userCashAppCollapse = userCashAppBtn.attr('data-target');
            var userId = $(this).attr('data-userId');

            //hide all open collapse except current
            $('.collapse').each(function( index ){
                if($(this).attr('data-userId') != userId){
                    $(this).collapse('hide');
                }
            });
            if($(this).attr('data-type') == 'load'){
                $('.thisBtn').each(function( index ){
                    $(this).removeClass();
                    //remove load-btn class from other buttons
                    if($(this).attr('data-userId') != userId){
                        $(this).addClass('btn btn-success thisBtn text-center');
                    }else{
                        $(this).addClass('btn btn-success thisBtn text-center load-btn-'+userId);
                    }
                });
                var loadBtn = $('.load-btn-'+userId);
                loadBtn.removeClass();
                loadBtn.addClass('btn btn-success thisBtn text-center load-btn load-btn-'+userId);
                loadBtnClickEvent();
            }

            if($(this).attr('data-type') == 'refer'){
                $('.thisBtn').each(function( index ){
                    $(this).removeClass();
                    //remove load-btn class from other buttons
                    if($(this).attr('data-userId') != userId){
                        $(this).addClass('btn btn-success thisBtn text-center');
                    }else{
                        $(this).addClass('btn btn-success thisBtn text-center refer-btn-'+userId);
                    }
                });
                var referBtn = $('.refer-btn-'+userId);
                referBtn.removeClass();
                referBtn.addClass('btn btn-success thisBtn text-center refer-btn refer-btn-'+userId);
                referBtnClickEvent();
            }
            if($(this).attr('data-type') == 'redeem'){
                $('.thisBtn').each(function( index ){
                    $(this).removeClass();
                    //remove load-btn class from other buttons
                    if($(this).attr('data-userId') != userId){
                        $(this).addClass('btn btn-success thisBtn text-center');
                    }else{
                        $(this).addClass('btn btn-success thisBtn text-center redeem-btn-'+userId);
                    }
                });
                var redeemBtn = $('.redeem-btn-'+userId);
                redeemBtn.removeClass();
                redeemBtn.addClass('btn btn-success thisBtn text-center redeem-btn redeem-btn-'+userId);
                redeemBtnClickEvent();
            }
            if($(this).attr('data-type') == 'tip'){
                $('.thisBtn').each(function( index ){
                    $(this).removeClass();
                    //remove load-btn class from other buttons
                    if($(this).attr('data-userId') != userId){
                        $(this).addClass('btn btn-success thisBtn text-center');
                    }else{
                        $(this).addClass('btn btn-success thisBtn text-center tip-btn-'+userId);
                    }
                });
                var tipBtn = $('.tip-btn-'+userId);
                tipBtn.removeClass();
                tipBtn.addClass('btn btn-success thisBtn text-center tip-btn tip-btn-'+userId);
                tipBtnClickEvent();
            }


        });
    });
    $(function() {
        $('.loadInput').on('keydown', function(e) {
            var userCashAppBtn = $(".user-" + $(this).attr('data-user'));
            var userCashAppCollapse = userCashAppBtn.attr('data-target');
            var userId = $(this).attr('data-userId');
            // console.log(userId);
            // var loadBtn = $('.load-btn-'+userId);
            // console.log(loadBtn);
            // loadBtn.removeClass();
            // loadBtn.addClass('btn btn-success dsf text-center load-btn load-btn-'+userId);
            // loadBtnClickEvent();
            if (e.which == 9) {
                $(userCashAppCollapse).collapse('hide');
        
                var nextBtn = $(".user-refer-" + $(this).attr('data-user'));
                var nextCollapse = nextBtn.attr('data-target');
                $(nextCollapse).collapse('show');
            }
            if (e.which === 13) {
                $(this).attr('disabled','disabled');
                // $('.load-btn').on('click', function(e) {
                if (($(this).val()) == '' || $(this).val() <= 0) {
                    $(this).removeAttr('disabled');
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(".load-from").attr("data-title");
                var gameId = $(this).parent().find('.load-from').val();
        
                var gameBtn = $("." + gameTitle + '-' + gameId + "");
        
                var user = $(this).attr('data-user');
        
                var userBalanceBtn = $(".user-" + $(this).attr('data-user'));
                // console.log(userBalanceBtn);
                var useRedeemBtn = $(".user-redeem-" + $(this).attr('data-user'));
                var userBalanceCollapse = userBalanceBtn.attr('data-target');
        
                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(userBalanceBtn.attr('data-balance'));
                // console.log(currentUserBalance);
                var amount = parseInt($(this).val());
        
                var cashAppId = $(".cash-app-btn").attr("data-id");
                var cashAppTitle = $(".cash-app-btn").attr("data-title");
                var cashAppBalance = $(".cash-app-btn").attr("data-balance");
                var cashAppBtn = $(".cash-app-btn");
                var userCashAppBtn = $(".user-cashapp-" + $('.cashApp-btn').attr('data-user'));
                var userCashAppCollapse = userCashAppBtn.attr('data-target');
                var currentCashAppBalance = parseInt(cashAppBalance);
                
                //  console.log(cashAppId + ',' + cashAppTitle + ',' + cashAppBalance + ',');
                // console.log(user + ','  + currentCashAppBalance + ',' + ', '+ gameId + ',' + amount);
        
                if (amount > currentGameBalance) {
                    $(this).removeAttr('disabled');
                    toastr.error('Balance to load is greater than the game balance.');
                    return;
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var type = "POST";
                    var ajaxurl = '/table-loadBalance';
                    var interval = null;
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        data: {
                            "gameId": gameId,
                            "userId": userId,
                            "amount": amount,
                            "cashAppId": cashAppId,
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            i = 0;
                            $(".load-btn").addClass("disabled");
                            interval = setInterval(function() {
                                i = ++i % 4;
                                $(".load-btn").html("Loading Balance" + Array(i + 1).join("."));
                            }, 300);
                        },
                        success: function(data) {
                            console.log('success');
                            $('.loadInput').removeAttr('disabled');
                            clearInterval(interval);
        
                            $(userBalanceCollapse).collapse('hide');
        
                            var totalGameBalance = currentGameBalance - amount;
                            console.log(amount + ', ' + currentUserBalance);
                            var totalUserBalance = amount + currentUserBalance;
                            console.log(totalUserBalance);
        
                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");
        
                            userBalanceBtn.attr('data-balance', totalUserBalance);
                            userBalanceBtn.text('$ ' + totalUserBalance);
        
        
                            // useRedeemBtn.attr('data-balance', totalUserBalance);
                            // useRedeemBtn.text('$ ' + totalUserBalance);
        
                            $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                            gameBtn.attr('data-balance', totalGameBalance);
                            // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);
        
                            amount = 0;
                            currentGameBalance = 0;
                            currentUserBalance = 0;
        
                            $('#exampleModalCenter').modal('hide');
                            toastr.success('Balance Loaded to User : ' + user);
        
                            $('.amount').val('');
                            $('.loadInput').val('');
        
                            // optionLoop = '';
                            // options = data;
                            // options.forEach(function(index) {
                            //   optionLoop +=
                            //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                            // });
                            // $(".load-from").html(optionLoop);
        
                        },
                        error: function(data) {
                            alert(data.responseText);
                            $(this).removeAttr('disabled');
                            clearInterval(interval);
                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");
                            toastr.error('Error', data.responseText);
                            console.log('error in loading balance');
                        }
                    });
                }
                // });
        
            }
        });
    });
    
    $(function() {
        $('.load-btn').on('click', function(e) {
            // var userCashAppBtn = $(".user-" + $('.loadInput').attr('data-user'));
            // var userCashAppCollapse = userCashAppBtn.attr('data-target');
            var dataUserId = $(this).attr('data-userId'); // Assuming 'this' refers to the element you want to target
            
            // Constructing the selector to target elements with the class '.referInput' and the appropriate 'data-userId' attribute
            var selector = '.referInput[data-userId="' + dataUserId + '"]';
            
            // Selecting the desired element using the constructed selector
            var userCashAppBtn = $(".user-refer-" + $(selector).attr('data-user'));
            
            // Accessing the 'data-target' attribute of the selected element
            var userCashAppCollapse = userCashAppBtn.attr('data-target');
            var userId = $(this).attr('data-userId');
            // console.log(userId);
            // var loadBtn = $('.load-btn-'+userId);
            // console.log(loadBtn);
            // loadBtn.removeClass();
            // loadBtn.addClass('btn btn-success dsf text-center load-btn load-btn-'+userId);
            // loadBtnClickEvent();
                $('.loadInput'+$(this).attr('data-userId')).attr('disabled','disabled');
                // $('.load-btn').on('click', function(e) {
                if (($('.loadInput'+$(this).attr('data-userId')).val()) == '' || $('.loadInput'+$(this).attr('data-userId')).val() <= 0) {
                    $('.loadInput'+$(this).attr('data-userId')).removeAttr('disabled');
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(".load-from").attr("data-title");
                var gameId = $(this).parent().find('.load-from').val();
        
                var gameBtn = $("." + gameTitle + '-' + gameId + "");
        
                var user = $(this).attr('data-user');
        
                var userBalanceBtn = $(".user-" + $(this).attr('data-user'));
                // console.log(userBalanceBtn);
                var useRedeemBtn = $(".user-redeem-" + $(this).attr('data-user'));
                var userBalanceCollapse = userBalanceBtn.attr('data-target');
        
                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(userBalanceBtn.attr('data-balance'));
                // console.log(currentUserBalance);
                var amount = parseInt($('.loadInput'+$(this).attr('data-userId')).val());
        
                var cashAppId = $(".cash-app-btn").attr("data-id");
                var cashAppTitle = $(".cash-app-btn").attr("data-title");
                var cashAppBalance = $(".cash-app-btn").attr("data-balance");
                var cashAppBtn = $(".cash-app-btn");
                var userCashAppBtn = $(".user-cashapp-" + $('.cashApp-btn').attr('data-user'));
                var userCashAppCollapse = userCashAppBtn.attr('data-target');
                var currentCashAppBalance = parseInt(cashAppBalance);
                
                //  console.log(cashAppId + ',' + cashAppTitle + ',' + cashAppBalance + ',');
                // console.log(user + ','  + currentCashAppBalance + ',' + ', '+ gameId + ',' + amount);
        
                if (amount > currentGameBalance) {
                    $('.loadInput'+$(this).attr('data-userId')).removeAttr('disabled');
                    toastr.error('Balance to load is greater than the game balance.');
                    return;
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var type = "POST";
                    var ajaxurl = '/table-loadBalance';
                    var interval = null;
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        data: {
                            "gameId": gameId,
                            "userId": userId,
                            "amount": amount,
                            "cashAppId": cashAppId,
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            i = 0;
                            $(".load-btn").addClass("disabled");
                            interval = setInterval(function() {
                                i = ++i % 4;
                                $(".load-btn").html("Loading Balance" + Array(i + 1).join("."));
                            }, 300);
                        },
                        success: function(data) {
                            console.log('success');
                            $('.loadInput'+$(this).attr('data-userId')).removeAttr('disabled');
                            clearInterval(interval);
        
                            $(userBalanceCollapse).collapse('hide');
        
                            var totalGameBalance = currentGameBalance - amount;
                            console.log(amount + ', ' + currentUserBalance);
                            var totalUserBalance = amount + currentUserBalance;
                            console.log(totalUserBalance);
        
                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");
        
                            userBalanceBtn.attr('data-balance', totalUserBalance);
                            userBalanceBtn.text('$ ' + totalUserBalance);
        
        
                            // useRedeemBtn.attr('data-balance', totalUserBalance);
                            // useRedeemBtn.text('$ ' + totalUserBalance);
        
                            $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                            gameBtn.attr('data-balance', totalGameBalance);
                            // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);
        
                            amount = 0;
                            currentGameBalance = 0;
                            currentUserBalance = 0;
        
                            $('#exampleModalCenter').modal('hide');
                            toastr.success('Balance Loaded to User : ' + user);
        
                            $('.amount').val('');
                            $('.loadInput'+$(this).attr('data-userId')).val('');
        
                            // optionLoop = '';
                            // options = data;
                            // options.forEach(function(index) {
                            //   optionLoop +=
                            //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                            // });
                            // $(".load-from").html(optionLoop);
        
                        },
                        error: function(data) {
                            alert(data.responseText);
                            $('.loadInput'+$(this).attr('data-userId')).removeAttr('disabled');
                            clearInterval(interval);
                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");
                            toastr.error('Error', data.responseText);
                            console.log('error in loading balance');
                        }
                    });
                }
                // });
        });
    });

    function loadBtnClickEvent(input){
        $(function() {
            $('body').on('click', ".load-btn", function(e) {
                e.stopImmediatePropagation();
                var loadInput = $('.loadInput'+$(this).attr('data-userid'));
                if ((loadInput) == '' || parseInt($(this).parent().find('.amount').val()) < 0) {
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $('.loadFrom'+$(this).attr('data-userid')).attr("data-title");
                var gameId = $('.loadFrom'+$(this).attr('data-userid')).val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userId');
                var userBalanceBtn = $(".user-" + $(this).attr('data-user'));
                var useRedeemBtn = $(".user-redeem-" + $(this).attr('data-user'));
                var userBalanceCollapse = userBalanceBtn.attr('data-target');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(userBalanceBtn.attr('data-balance'));

                var amount = parseInt(loadInput.val());


                var cashAppId = $(".cash-app-btn").attr("data-id");
                var cashAppTitle = $(".cash-app-btn").attr("data-title");
                var cashAppBalance = $(".cash-app-btn").attr("data-balance");
                var cashAppBtn = $(".cash-app-btn");
                var userCashAppBtn = $(".user-cashapp-" + $('.cashApp-btn').attr('data-user'));
                var userCashAppCollapse = userCashAppBtn.attr('data-target');
                var currentCashAppBalance = parseInt(cashAppBalance);


                if (amount > currentGameBalance) {
                    toastr.error('Balance to load is greater than the game balance.');
                    return;
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var type = "POST";
                    var ajaxurl = '/table-loadBalance';
                    var interval = null;
                    $.ajax({
                        type: type,
                        url: ajaxurl,
                        data: {
                            "gameId": gameId,
                            "userId": userId,
                            "amount": amount,
                            "cashAppId": cashAppId,
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            i = 0;
                            $(".load-btn").addClass("disabled");
                            interval = setInterval(function() {
                                i = ++i % 4;
                                $(".load-btn").html("Loading Balance" + Array(i + 1).join("."));
                            }, 300);
                        },
                        success: function(data) {
                            clearInterval(interval);

                            $(userBalanceCollapse).collapse('hide');

                            var totalCashAppBalance = currentCashAppBalance + amount;
                            var totalGameBalance = currentGameBalance - amount;
                            var totalUserBalance = amount + currentUserBalance;

                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");

                            userBalanceBtn.attr('data-balance', totalUserBalance);
                            userBalanceBtn.text('$ ' + totalUserBalance);

                            cashAppBtn.attr('data-balance', totalCashAppBalance);
                            cashAppBtn.text('Cash App Acccount : ' + cashAppTitle + ': $ ' + totalCashAppBalance);
                            userCashAppBtn.attr('data-balance', totalUserBalance);
                            userCashAppBtn.text('$ ' + totalUserBalance);

                            $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);

                            // useRedeemBtn.attr('data-balance', totalUserBalance);
                            // useRedeemBtn.text('$ ' + totalUserBalance);

                            gameBtn.attr('data-balance', totalGameBalance);
                            // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                            amount = 0;
                            currentGameBalance = 0;
                            currentUserBalance = 0;

                            $('#exampleModalCenter').modal('hide');
                            toastr.success('Balance Loaded to User : ' + user);

                            $('.amount').val('');
                            clearBtns();
                            $( ".load-btn" ).off("click");

                        },
                        error: function(data) {
                            clearInterval(interval);
                            $(".load-btn").removeClass("disabled");
                            $(".load-btn").html("Load");
                            toastr.error('Error', data.responseText);
                            console.log('error in loading balance');
                        }
                    });
                }
            });
        });
    }

    $(function() {
        $('.redeemInput').on('keydown', function(e) {
            var userCashAppBtn = $(".user-redeem-" + $(this).attr('data-user'));
            var userCashAppCollapse = userCashAppBtn.attr('data-target');


            if (e.which == 9) {
                $(userCashAppCollapse).collapse('hide');

                var nextBtn = $(".user-tip-" + $(this).attr('data-user'));
                var nextCollapse = nextBtn.attr('data-target');
                $(nextCollapse).collapse('show');

                // console.log($(".user-" + $(this).attr('data-user')).attr('data-target'));
                // $(".user-" + $(this).attr('data-user')).attr('data-target').nextCollapse('show');
                // attr('data-target').collapse('show')
            }
            if (e.which === 13) {
                $(this).attr('disabled','disabled');
                // $('.redeem-btn').on('click', function(e) {
                if (($(this).val()) == '' || $(this).val() <= 0) {
                    $(this).removeAttr('disabled');
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(".redeem-from").attr("data-title");
                var gameId = $(this).parent().find('.redeem-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userId');
                var userBalanceBtn = $(".user-" + $(this).attr('data-user'));
                var useRedeemBtn = $(".user-redeem-" + $(this).attr('data-user'));
                var userCashAppCollapse = useRedeemBtn.attr('data-target');


                var cashAppBtn = $('.cash-app-btn');
                var cashAppId = $('.cash-app-btn').attr('data-id');
                var cashAppBlncSpan = $('.cash-app-blnc');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(useRedeemBtn.attr('data-balance'));
                var currentCashAppBlnc = parseInt(cashAppBtn.attr('data-balance'));

                var amount = parseInt($(this).val());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var type = "POST";
                var ajaxurl = '/table-redeemBalance';
                var interval = null;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: {
                        "gameId": gameId,
                        "userId": userId,
                        "amount": amount,
                        "cashAppId": cashAppId,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        i = 0;
                        interval = setInterval(function() {
                            i = ++i % 4;
                            $(".redeem-btn").html("Redeeming Balance" + Array(i + 1).join("."));
                        }, 300);
                    },
                    success: function(data) {
                        $('.redeemInput').removeAttr('disabled');
                        clearInterval(interval);

                        $(userCashAppCollapse).collapse('hide');

                        var totalGameBalance = currentGameBalance + amount;
                        var totalUserBalance = currentUserBalance + amount;
                        var totalCashAppBalance = currentCashAppBlnc - amount;

                        $(".redeem-btn").removeClass("disabled");
                        $(".redeem-btn").html("Load");

                        useRedeemBtn.attr('data-balance', totalUserBalance);
                        useRedeemBtn.text('$ ' + totalUserBalance);

                        // userBalanceBtn.attr('data-balance', totalUserBalance);
                        // userBalanceBtn.text('$ ' + totalUserBalance);

                        gameBtn.attr('data-balance', totalGameBalance);
                        gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                        cashAppBtn.attr('data-balance', totalCashAppBalance);
                        cashAppBlncSpan.text('$ ' + totalCashAppBalance);

                        amount = 0;
                        currentGameBalance = 0;
                        currentUserBalance = 0;

                        $('#exampleModalCenter').modal('hide');
                        toastr.success('Balance Redeemed for : ' + user);

                        $('.amount').val('');
                        $('.redeemInput').val('');
                        // optionLoop = '';
                        // options = data;
                        // options.forEach(function(index) {
                        //   optionLoop +=
                        //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                        // });
                        // $(".load-from").html(optionLoop);

                    },
                    error: function(data) {
                        $('.redeemInput').removeAttr('disabled');
                        clearInterval(interval);
                        $(".load-btn").removeClass("disabled");
                        $(".load-btn").html("Load");
                        toastr.error('Error', data.responseText);
                        console.log('error in loading balance');
                    }
                });
                // });

            }
        });
    });
    
    $(function() {
        $('.redeem-btn').on('click', function(e) {
            var dataUserId = $(this).attr('data-userId'); // Assuming 'this' refers to the element you want to target
        
                // Constructing the selector to target elements with the class '.referInput' and the appropriate 'data-userId' attribute
                var selector = '.referInput[data-userId="' + dataUserId + '"]';
                
                // Selecting the desired element using the constructed selector
                var userCashAppBtn = $(".user-refer-" + $(selector).attr('data-user'));
                
                // Accessing the 'data-target' attribute of the selected element
                var userCashAppCollapse = userCashAppBtn.attr('data-target');

                $('.redeemInput'+$(this).attr('data-userId')).attr('disabled','disabled');
                // $('.redeem-btn').on('click', function(e) {
                if (($('.redeemInput'+$(this).attr('data-userId')).val()) == '' || $('.redeemInput'+$(this).attr('data-userId')).val() <= 0) {
                    $('.redeemInput'+$(this).attr('data-userId')).removeAttr('disabled');
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(".redeem-from").attr("data-title");
                var gameId = $(this).parent().find('.redeem-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userId');
                var userBalanceBtn = $(".user-" +(this).attr('data-user'));
                var useRedeemBtn = $(".user-redeem-" + $('.redeemInput'+$(this).attr('data-user')));
                var userCashAppCollapse = useRedeemBtn.attr('data-target');


                var cashAppBtn = $('.cash-app-btn');
                var cashAppId = $('.cash-app-btn').attr('data-id');
                var cashAppBlncSpan = $('.cash-app-blnc');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(useRedeemBtn.attr('data-balance'));
                var currentCashAppBlnc = parseInt(cashAppBtn.attr('data-balance'));

                var amount = parseInt($('.redeemInput'+$(this).attr('data-userId')).val());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var type = "POST";
                var ajaxurl = '/table-redeemBalance';
                var interval = null;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: {
                        "gameId": gameId,
                        "userId": userId,
                        "amount": amount,
                        "cashAppId": cashAppId,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        i = 0;
                        interval = setInterval(function() {
                            i = ++i % 4;
                            $(".redeem-btn").html("Redeeming Balance" + Array(i + 1).join("."));
                        }, 300);
                    },
                    success: function(data) {
                        $('.redeemInput'+$(this).attr('data-userId')).removeAttr('disabled');
                        clearInterval(interval);

                        $(userCashAppCollapse).collapse('hide');

                        var totalGameBalance = currentGameBalance + amount;
                        var totalUserBalance = currentUserBalance + amount;
                        var totalCashAppBalance = currentCashAppBlnc - amount;

                        $(".redeem-btn").removeClass("disabled");
                        $(".redeem-btn").html("Load");

                        useRedeemBtn.attr('data-balance', totalUserBalance);
                        useRedeemBtn.text('$ ' + totalUserBalance);

                        // userBalanceBtn.attr('data-balance', totalUserBalance);
                        // userBalanceBtn.text('$ ' + totalUserBalance);

                        gameBtn.attr('data-balance', totalGameBalance);
                        gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                        cashAppBtn.attr('data-balance', totalCashAppBalance);
                        cashAppBlncSpan.text('$ ' + totalCashAppBalance);

                        amount = 0;
                        currentGameBalance = 0;
                        currentUserBalance = 0;

                        $('#exampleModalCenter').modal('hide');
                        toastr.success('Balance Redeemed for : ' + user);

                        $('.amount').val('');
                        $('.redeemInput'+(this).attr('data-userId')).val('');
                        // optionLoop = '';
                        // options = data;
                        // options.forEach(function(index) {
                        //   optionLoop +=
                        //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                        // });
                        // $(".load-from").html(optionLoop);

                    },
                    error: function(data) {
                        $('.redeemInput'+$(this).attr('data-userId')).removeAttr('disabled');
                        clearInterval(interval);
                        $(".load-btn").removeClass("disabled");
                        $(".load-btn").html("Load");
                        toastr.error('Error', data.responseText);
                        console.log('error in loading balance');
                    }
                });
                // });
        });
    });


    function redeemBtnClickEvent(input){
        $(function() {
            $('body').on('click','.redeem-btn', function(e) {
                console.log('111');
                e.stopImmediatePropagation();
                var redeemInput = $('.redeemInput'+$(this).attr('data-userid'));
                if ((redeemInput) == '' || parseInt(redeemInput) < 0) {
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $('.loadFrom'+$(this).attr('data-userid')).attr("data-title");
                var gameId = $('.loadFrom'+$(this).attr('data-userid')).val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userId');
                var userBalanceBtn = $(".user-" + $(this).attr('data-user'));
                var useRedeemBtn = $(".user-redeem-" + $(this).attr('data-user'));
                var userCashAppCollapse = useRedeemBtn.attr('data-target');


                var cashAppBtn = $('.cash-app-btn');
                var cashAppId = $('.cash-app-btn').attr('data-id');
                var cashAppBlncSpan = $('.cash-app-blnc');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(useRedeemBtn.attr('data-balance'));
                var currentCashAppBlnc = parseInt(cashAppBtn.attr('data-balance'));

                var amount = parseInt(redeemInput.val());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var type = "POST";
                var ajaxurl = '/table-redeemBalance';
                var interval = null;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: {
                        "gameId": gameId,
                        "userId": userId,
                        "amount": amount,
                        "cashAppId": cashAppId,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        i = 0;
                        $(".redeem-btn").addClass("disabled");
                        interval = setInterval(function() {
                            i = ++i % 4;
                            $(".redeem-btn").html("Loading Balance" + Array(i + 1).join("."));
                        }, 300);
                    },
                    success: function(data) {
                        clearInterval(interval);

                        $(userCashAppCollapse).collapse('hide');

                        var totalGameBalance = currentGameBalance + amount;
                        var totalUserBalance = currentUserBalance + amount;
                        var totalCashAppBalance = currentCashAppBlnc - amount;

                        $(".redeem-btn").removeClass("disabled");
                        $(".redeem-btn").html("Load");

                        useRedeemBtn.attr('data-balance', totalUserBalance);
                        useRedeemBtn.text('$ ' + totalUserBalance);

                        // userBalanceBtn.attr('data-balance', totalUserBalance);
                        // userBalanceBtn.text('$ ' + totalUserBalance);

                        gameBtn.attr('data-balance', totalGameBalance);
                        gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                        cashAppBtn.attr('data-balance', totalCashAppBalance);
                        cashAppBlncSpan.text('$ ' + totalCashAppBalance);

                        amount = 0;
                        currentGameBalance = 0;
                        currentUserBalance = 0;

                        $('#exampleModalCenter').modal('hide');
                        toastr.success('Balance Redeemed for : ' + user);

                        $('.amount').val('');
                        clearBtns();
                        $( ".redeem-btn" ).off("click");

                        // optionLoop = '';
                        // options = data;
                        // options.forEach(function(index) {
                        //   optionLoop +=
                        //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                        // });
                        // $(".load-from").html(optionLoop);

                    },
                    error: function(data) {
                        clearInterval(interval);
                        $(".load-btn").removeClass("disabled");
                        $(".load-btn").html("Load");
                        toastr.error('Error', data.responseText);
                        console.log('error in loading balance');
                    }
                });
            });
        });
    }
    $(function() {
        $('.tipInput').on('keydown', function(e) {
            if (e.which === 13) {
                $(this).attr('disabled','disabled');
                // $('.tip-btn').on('click', function(e) {
                if (($(this).val()) == '' || $(this).val() <= 0) {
                    $(this).removeAttr('disabled');
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(".tip-from").attr("data-title");
                var gameId = $(this).parent().find('.tip-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userId');
                var userBalanceBtn = $(".user-tip-" + $(this).attr('data-user'));
                // var useRedeemBtn = $(".user-redeem-" + $(this).attr('data-user'));
                var userTipCollapse = userBalanceBtn.attr('data-target');


                // var cashAppBtn = $('.cash-app-btn');
                // var cashAppId = $('.cash-app-btn').attr('data-id');
                // var cashAppBlncSpan = $('.cash-app-blnc');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(userBalanceBtn.attr('data-balance'));
                // var currentCashAppBlnc = parseInt(cashAppBtn.attr('data-balance'));

                var amount = parseInt($(this).val());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var type = "POST";
                var ajaxurl = '/table-tipBalance';
                var interval = null;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: {
                        "gameId": gameId,
                        "userId": userId,
                        "amount": amount,
                        // "cashAppId": cashAppId,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        i = 0;
                        $(".tip-btn").addClass("disabled");
                        interval = setInterval(function() {
                            i = ++i % 4;
                            $(".tip-btn").html("Load" + Array(i + 1).join("."));
                        }, 300);
                    },
                    success: function(data) {
                        $('.tipInput').removeAttr('disabled');
                        clearInterval(interval);

                        $(userTipCollapse).collapse('hide');

                        var totalGameBalance = currentGameBalance + amount;
                        var totalUserBalance = currentUserBalance + amount;
                        // var totalCashAppBalance = currentCashAppBlnc - amount;

                        $(".tip-btn").removeClass("disabled");
                        $(".tip-btn").html("Load");

                        // useRedeemBtn.attr('data-balance', totalUserBalance);
                        // useRedeemBtn.text('$ ' + totalUserBalance);

                        userBalanceBtn.attr('data-balance', totalUserBalance);
                        userBalanceBtn.text('$ ' + totalUserBalance);

                        gameBtn.attr('data-balance', totalGameBalance);
                        $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                        // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                        // cashAppBtn.attr('data-balance', totalCashAppBalance);
                        // cashAppBlncSpan.text('$ ' + totalCashAppBalance);

                        amount = 0;
                        currentGameBalance = 0;
                        currentUserBalance = 0;

                        // $('#exampleModalCenter').modal('hide');
                        toastr.success('Balance Tipped from : ' + user);

                        $('.amount').val('');
                        $('.tipInput').val('');
                        // optionLoop = '';
                        // options = data;
                        // options.forEach(function(index) {
                        //   optionLoop +=
                        //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                        // });
                        // $(".load-from").html(optionLoop);

                    },
                    error: function(data) {
                        $('.tipInput').removeAttr('disabled');
                        clearInterval(interval);
                        $(".tip-btn").removeClass("disabled");
                        $(".tip-btn").html("Tip");
                        toastr.error('Error', data.responseText);
                        console.log('error in tipping balance');
                    }
                });
                // });

            }
        });
    });
    $(function() {
        $('.tip-btn').on('click', function(e) {
           
                $('.tipInput'+$(this).attr('data-userId')).attr('disabled','disabled');
                // $('.tip-btn').on('click', function(e) {
                if (($('.tipInput'+$(this).attr('data-userId')).val()) == '' || $('.tipInput'+$(this).attr('data-userId')).val() <= 0) {
                    $('.tipInput'+$(this).attr('data-userId')).removeAttr('disabled');
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $(".tip-from").attr("data-title");
                var gameId = $(this).parent().find('.tip-from').val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userId');
                var userBalanceBtn = $(".user-tip-" + $(this).attr('data-user'));
                // var useRedeemBtn = $(".user-redeem-" + $(this).attr('data-user'));
                var userTipCollapse = userBalanceBtn.attr('data-target');


                // var cashAppBtn = $('.cash-app-btn');
                // var cashAppId = $('.cash-app-btn').attr('data-id');
                // var cashAppBlncSpan = $('.cash-app-blnc');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(userBalanceBtn.attr('data-balance'));
                // var currentCashAppBlnc = parseInt(cashAppBtn.attr('data-balance'));

                var amount = parseInt($('.tipInput'+$(this).attr('data-userId')).val());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var type = "POST";
                var ajaxurl = '/table-tipBalance';
                var interval = null;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: {
                        "gameId": gameId,
                        "userId": userId,
                        "amount": amount,
                        // "cashAppId": cashAppId,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        i = 0;
                        $(".tip-btn").addClass("disabled");
                        interval = setInterval(function() {
                            i = ++i % 4;
                            $(".tip-btn").html("Load" + Array(i + 1).join("."));
                        }, 300);
                    },
                    success: function(data) {
                        $('.tipInput'+$(this).attr('data-userId')).removeAttr('disabled');
                        clearInterval(interval);

                        $(userTipCollapse).collapse('hide');

                        var totalGameBalance = currentGameBalance + amount;
                        var totalUserBalance = currentUserBalance + amount;
                        // var totalCashAppBalance = currentCashAppBlnc - amount;

                        $(".tip-btn").removeClass("disabled");
                        $(".tip-btn").html("Load");

                        // useRedeemBtn.attr('data-balance', totalUserBalance);
                        // useRedeemBtn.text('$ ' + totalUserBalance);

                        userBalanceBtn.attr('data-balance', totalUserBalance);
                        userBalanceBtn.text('$ ' + totalUserBalance);

                        gameBtn.attr('data-balance', totalGameBalance);
                        $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);
                        // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                        // cashAppBtn.attr('data-balance', totalCashAppBalance);
                        // cashAppBlncSpan.text('$ ' + totalCashAppBalance);

                        amount = 0;
                        currentGameBalance = 0;
                        currentUserBalance = 0;

                        // $('#exampleModalCenter').modal('hide');
                        toastr.success('Balance Tipped from : ' + user);

                        $('.amount').val('');
                        $('.tipInput').val('');
                        // optionLoop = '';
                        // options = data;
                        // options.forEach(function(index) {
                        //   optionLoop +=
                        //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                        // });
                        // $(".load-from").html(optionLoop);

                    },
                    error: function(data) {
                        $('.tipInput'+$(this).attr('data-userId')).removeAttr('disabled');
                        clearInterval(interval);
                        $(".tip-btn").removeClass("disabled");
                        $(".tip-btn").html("Tip");
                        toastr.error('Error', data.responseText);
                        console.log('error in tipping balance');
                    }
                });
                // });
        });
    });

    function tipBtnClickEvent(input){
        $(function() {
            $('body').on('click','.tip-btn', function(e) {
                e.stopImmediatePropagation();
                var tipInput = $('.tipInput'+$(this).attr('data-userid'));
                if ((tipInput) == '' || parseInt(tipInput) < 0) {
                    toastr.error('Please enter a valid amount.');
                    return;
                }
                var gameTitle = $('.loadFrom'+$(this).attr('data-userid')).attr("data-title");
                var gameId = $('.loadFrom'+$(this).attr('data-userid')).val();

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userId');
                var userBalanceBtn = $(".user-tip-" + $(this).attr('data-user'));
                // var useRedeemBtn = $(".user-redeem-" + $(this).attr('data-user'));
                var userTipCollapse = userBalanceBtn.attr('data-target');


                // var cashAppBtn = $('.cash-app-btn');
                // var cashAppId = $('.cash-app-btn').attr('data-id');
                // var cashAppBlncSpan = $('.cash-app-blnc');

                var currentGameBalance = parseInt(gameBtn.attr('data-balance'));
                var currentUserBalance = parseInt(userBalanceBtn.attr('data-balance'));
                // var currentCashAppBlnc = parseInt(cashAppBtn.attr('data-balance'));

                var amount = parseInt(tipInput.val());

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var type = "POST";
                var ajaxurl = '/table-tipBalance';
                var interval = null;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: {
                        "gameId": gameId,
                        "userId": userId,
                        "amount": amount,
                        // "cashAppId": cashAppId,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        i = 0;
                        $(".tip-btn").addClass("disabled");
                        interval = setInterval(function() {
                            i = ++i % 4;
                            $(".tip-btn").html("Load" + Array(i + 1).join("."));
                        }, 300);
                    },
                    success: function(data) {
                        clearInterval(interval);

                        $(userTipCollapse).collapse('hide');

                        var totalGameBalance = currentGameBalance + amount;
                        console.log(totalGameBalance);
                        var totalUserBalance = currentUserBalance + amount;
                        // var totalCashAppBalance = currentCashAppBlnc - amount;

                        $(".tip-btn").removeClass("disabled");
                        $(".tip-btn").html("Load");

                        // useRedeemBtn.attr('data-balance', totalUserBalance);
                        // useRedeemBtn.text('$ ' + totalUserBalance);

                        userBalanceBtn.attr('data-balance', totalUserBalance);
                        userBalanceBtn.text('$ ' + totalUserBalance);

                        $(".span-" + gameTitle + '-' + gameId + "").text('$ ' + totalGameBalance);

                        gameBtn.attr('data-balance', totalGameBalance);
                        // gameBtn.text(gameTitle.replace("-", " ") + ' : ' + totalGameBalance);

                        // cashAppBtn.attr('data-balance', totalCashAppBalance);
                        // cashAppBlncSpan.text('$ ' + totalCashAppBalance);

                        amount = 0;
                        currentGameBalance = 0;
                        currentUserBalance = 0;

                        // $('#exampleModalCenter').modal('hide');
                        toastr.success('Balance Tipped from : ' + user);

                        $('.amount').val('');
                        clearBtns();

                        $( ".tip-btn" ).off("click");

                        // optionLoop = '';
                        // options = data;
                        // options.forEach(function(index) {
                        //   optionLoop +=
                        //   '<option data-balance="'+index.balance+'" data-title="'+index.title+'" value="'+index.id+'">'+index.title+' : '+index.balance+'</option>';
                        // });
                        // $(".load-from").html(optionLoop);

                    },
                    error: function(data) {
                        clearInterval(interval);
                        $(".tip-btn").removeClass("disabled");
                        $(".tip-btn").html("Load");
                        toastr.error('Error', data.responseText);
                        console.log('error in tipping balance');
                    }
                });
            });
        });
    }

        $(function() {
            $('.remove-form-game').on('click', function(e) {
                var gameTitle = $(".tip-from").attr("data-title");
                var gameId = $(this).attr("data-game");

                var gameBtn = $("." + gameTitle + '-' + gameId + "");

                var user = $(this).attr('data-user');
                var userId = $(this).attr('data-userId');

                var formtr = $("#form-games-div-" + $(this).attr('data-tr'));


                e.preventDefault();
                Swal.fire({
                title: 'Are you sure you want to delete this?',
                showDenyButton: true,
                showCancelButton: true,
                showConfirmButton: false,
                // confirmButtonText: 'Save',
                denyButtonText: `Delete`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('asd');
                    }
                    else if (result.isDenied) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var type = "POST";
                        var ajaxurl = '/remove-form-game';
                        // var interval = null;
                        $.ajax({
                            type: type,
                            url: ajaxurl,
                            data: {
                                "gameId": gameId,
                                "userId": userId,
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                // i = 0;
                                // $(".tip-btn").addClass("disabled");
                                // interval = setInterval(function() {
                                //     i = ++i % 4;
                                //     $(".tip-btn").html("Tip" + Array(i + 1).join("."));
                                // }, 300);
                            },
                            success: function(data) {

                                formtr.remove();
                                $( ".count-row" ).each(function( index ) {
                                    $(this).text((index+1));
                                    // console.log( index + ": " + $( this ).text() );
                                });
                                toastr.success('Player Delete');
                            },
                            error: function(data) {
                                toastr.error('Error', data.responseText);
                                console.log('error in tipping balance');
                            }
                        });
                    }
                });
            });
        });
        $(function() {
            $('.edit-game-table').on('click', function(e) {
                $('.game_id').val($(this).data('id'));
            });
        });
        $(function() {
            $('.history-type-change-btn').on('click', function(e) {
                $('.user-current-game-history-input').val($(this).data('type'));
                // $('.filter-history').trigger('click');
                e.stopImmediatePropagation();
                // console.log('a');
                var historyType = '';
                if ($(this).hasClass('form-all')) {
                    historyType = 1;
                    var filter_type = $(this).data('type');
                    var filter_start = $('.filter-start1').val();
                    var filter_end = $('.filter-end1').val();
                } else {
                    var filter_type = $(this).data('type');
                    var filter_start = $('.filter-start').val();
                    var filter_end = $('.filter-end').val();
                }

                var userId = $(this).attr("data-userId");
                var game = $(this).attr("data-game");
                var game = $(this).attr("data-game");
                // console.log(userId,game)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var actionType = "POST";
                var ajaxurl = '/filter-user-history';
                $.ajax({
                    type: actionType,
                    url: ajaxurl,
                    data: {
                        "filter_type": filter_type,
                        "userId": userId,
                        "game": game,
                        "filter_start": filter_start,
                        "filter_end": filter_end,
                        "historyType": historyType,
                    },
                    dataType: 'json',
                    beforeSend: function() {},
                    success: function(data) {
                        // console.log(data);

                        $('.total-tip').text(0);
                        $('.total-balance').text(0);
                        $('.total-redeem').text(0);
                        $('.total-refer').text(0);
                        $('.total-amount').text(0);
                        $('.total-profit').text(0);
                        if (data[0] != '') {
                            optionLoop = '';
                            options = data[0];
                            var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                            if (historyType == '') {
                                options.forEach(function(index) {
                                    var date_format = new Date(index.created_at);
                                    var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                                    optionLoop +=
                                        '<tr><td class="text-center">' + a + '</td><td class="text-center"><span class="badge  bg-gradient-success"> ' + index.amount_loaded + '$</span></td><td class="text-center">'
                                        + ((index.type == 'refer')?'bonus':index.type)  + '</td><td class="text-center">' + index.created_by.name + '</td></tr>';
                                });
                                `    `
                                // console.log('yhere');
                            } else {
                                console.log(data[1].tip);
                                $('.total-tip').text(data[1].tip);
                                $('.total-balance').text(data[1].load);
                                $('.total-redeem').text(data[1].redeem);
                                $('.total-refer').text(data[1].refer);
                                $('.total-amount').text(data[1].cashAppLoad);
                                $('.total-profit').text(data[1].profit);
                                options.forEach(function(index) {
                                    var date_format = new Date(index.created_at);
                                    var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                                    optionLoop +=
                                        '<tr><td class="text-center">' + a + '</td><td class="text-center">' + index.account.name + '</td><td class="text-center"><span class="badge  bg-gradient-success"> ' + index.amount_loaded + '$</span></td><td class="text-center">'
                                        + ((index.type == 'refer')?'bonus':index.type)  + '</td><td class="text-center">' + index.created_by.name + '</td></tr>';
                                });
                            }

                        } else {
                            optionLoop = '<tr><td>No History</td></tr>';
                        }
                        $(".user-history-body").html(optionLoop);

                    },
                    error: function(data) {
                        toastr.error('Error', data.responseText);
                    }
                });
            });
        });

    $('.this-day-history').on('click', function(e) {
        var month_symbols = ['','January', 'February', 'March', 'April', 'May', 'June', 'July', 'September', 'October', 'November', 'December'];
        var year = $(this).attr("data-year");
        var month = $(this).attr("data-month");
        var day = $(this).attr("data-day");
        var category = $(this).attr("data-category");
        $('h2.popup-title').html('History of '+month_symbols[month.replace(/^0+/, '')]+' '+day+', '+year);
        $('.history-type-change-btn-allDate').attr('data-day',day);
        $('.history-type-change-btn-allDate.game-category').removeClass('active-game-btn');
        $('.history-type-change-btn-allDate.game-type').removeClass('active-game-btn');
        $('.history-type-change-btn-allDate.game-category').attr('data-type','all');
        $('.history-type-change-btn-allDate.game-category[data-category="'+category+'"]').addClass('active-game-btn');
        $('.history-type-change-btn-allDate.game-type').attr('data-category',category);
        $('.history-type-change-btn-allDate.game-type[data-type="all"]').addClass('active-game-btn');
        $('.game-category-info.reset-to-blank').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "POST";
        var ajaxurl = '/this-day-history';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {
                "year": year,
                "month": month,
                "day": day,
                "category": category,
            },
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(data) {
                var accounts = data.accounts;
                var default_accounts = data.default_accounts;
                $.each($('.history-type-change-btn-allDate.game-category'), function() {
                    var that = $(this);
                    $.each(accounts, function(index,value){
                        if(value.game_name == that.attr('data-category')) {
                            that.siblings('.game-category-info.reset-to-blank').html('\
                            Game Title: '+value.game_title+'\
                            <br>Game Balance: '+value.game_balance+'\
                            <br>Tip: '+value.totals.tip+'\
                            <br>Load: '+value.totals.load+'\
                            <br>Redeem: '+value.totals.redeem+'\
                            <br>Bonus: '+value.totals.refer+'\
                            ');
                        } else if(that.siblings('.game-category-info.reset-to-blank').html() == '') {
                            $.each(default_accounts, function(index,value){
                                if(value.name == that.attr('data-category')) {
                                    that.siblings('.game-category-info.reset-to-blank').html('\
                                    Game Title: '+value.title+'\
                                    <br>Game Balance: '+value.balance+'\
                                    <br>Tip: 0\
                                    <br>Load: 0\
                                    <br>Redeem: 0\
                                    <br>Bonus: 0\
                                    ');
                                }
                            });
                        }
                    });
                });
                if (data.grouped != '') {
                    var optionLoop = '',
                    options = data.grouped;
                    var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    options.forEach(function(index) {
                        var date_format = new Date(index.created_at),
                            load = index.type == 'load' ? parseInt(index.amount_loaded) : 0,
                            redeem = index.type == 'redeem' ? parseInt(index.amount_loaded) : 0;
                            profitLoss = load - redeem;
                        // var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        var a =  date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        optionLoop +=
                            '<tr><td class="text-center">' + a + '</td>\
                            <td class="text-center"><span class="badge  bg-gradient-success"> ' + index.amount_loaded + '$</span></td>\
                            <td class="text-center">' + index.form.facebook_name + '</td>\
                            <td class="text-center">' + (profitLoss < 0 ? '<span class="badge bg-gradient-warning">'+profitLoss+'$</span>' : '<span class="badge bg-gradient-success">'+profitLoss+'$</span>') + '</td>\
                            <td class="text-center">' + index.account.name + '</td>\
                            <td class="text-center">' + index.form_game.game_id + '</td>\
                            <td class="text-center">' + ((index.type == 'refer')?'bonus':index.type)  + '</td>\
                            <td class="text-center">' + index.created_by.name + '</td></tr>';
                    });

                } else {
                    optionLoop = '<tr><td>No History</td></tr>';
                }
                $(".user-history-body").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
    });

    $('.this-day-game-history').on('click', function(e) {
        var year = $(this).attr("data-year");
        var month = $(this).attr("data-month");
        var day = $(this).attr("data-day");
        var game = $(this).attr("data-game");
        $('.history-type-change-btn-allDate').attr('data-day',day);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var actionType = "POST";
        var ajaxurl = '/this-day-game-history';
        $.ajax({
            type: actionType,
            url: ajaxurl,
            data: {
                "year": year,
                "month": month,
                "day": day,
                "game": game,
            },
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(data) {
                if (data != '') {
                    optionLoop = '';
                    options = data;
                    var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    options.forEach(function(index) {
                        var date_format = new Date(index.created_at);
                        var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        optionLoop +=
                            '<tr><td class="text-center">' + a + '</td><td class="text-center"><span class="badge  bg-gradient-success"> ' + index.amount_loaded + '$</span></td><td class="text-center">' + ((index.type == 'refer')?'bonus':index.type)  + '</td><td class="text-center">' + index.created_by.name + '</td></tr>';
                    });
                } else {
                    optionLoop = '<tr><td>No History</td></tr>';
                }
                $(".user-history-body").html(optionLoop);

            },
            error: function(data) {
                toastr.error('Error', data.responseText);
            }
        });
    });
        $(function() {
            $('.history-type-change-btn-allDate').on('click', function(e) {
                // $('.user-current-game-history-input').val($(this).data('type'));
                // $('.filter-history').trigger('click');
                e.stopImmediatePropagation();
                // console.log('a');
                var historyType = '';
                historyType = 1;
                var filter_type = $(this).data('type');
                var filter_year = $(this).data('year');
                var filter_month = $(this).data('month');
                var filter_day = $(this).data('day');
                var filter_category = $(this).data('category');

                if($(this).hasClass('game-type')) {
                    $('.history-type-change-btn-allDate.game-type').removeClass('active-game-btn');
                    $('.history-type-change-btn-allDate.game-category').attr('data-type',filter_type);
                    $(this).addClass('active-game-btn');
                }

                if($(this).hasClass('game-category')) {
                    $('.history-type-change-btn-allDate.game-category').removeClass('active-game-btn');
                    $('.history-type-change-btn-allDate.game-type').attr('data-category',filter_category);
                    $(this).addClass('active-game-btn');
                }

                // var userId = $(this).attr("data-userId");
                // var game = $(this).attr("data-game");
                // var game = $(this).attr("data-game");
                // console.log(userId,game)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                var actionType = "POST";
                var ajaxurl = '/filter-user-history-allData';
                $.ajax({
                    type: actionType,
                    url: ajaxurl,
                    data: {
                        "filter_type": filter_type,
                        "filter_year": filter_year,
                        "filter_month": filter_month,
                        "filter_day": filter_day,
                        "filter_category": filter_category,
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $(".user-history-body").html('');
                    },
                    success: function(data) {

                        // $('.total-tip').text(0);
                        // $('.total-balance').text(0);
                        // $('.total-redeem').text(0);
                        // $('.total-refer').text(0);
                        // $('.total-amount').text(0);
                        // $('.total-profit').text(0);
                        if (data[0] != '') {
                            optionLoop = '';
                            options = data;
                            var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                            // if (historyType == '') {
                            //     options.forEach(function(index) {
                            //         var date_format = new Date(index.created_at);
                            //         var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                            //         optionLoop +=
                            //             '<tr><td class="text-center">' + a + '</td><td class="text-center"><span class="badge  bg-gradient-success"> ' + index.amount_loaded + '$</span></td><td class="text-center">'
                            //             + ((index.type == 'refer')?'bonus':index.type)  + '</td><td class="text-center">' + index.created_by.name + '</td></tr>';
                            //     });
                            //     `    `
                            //     // console.log('yhere');
                            // } else {
                            //     console.log(data[1].tip);
                            //     $('.total-tip').text(data[1].tip);
                            //     $('.total-balance').text(data[1].load);
                            //     $('.total-redeem').text(data[1].redeem);
                            //     $('.total-refer').text(data[1].refer);
                            //     $('.total-amount').text(data[1].cashAppLoad);
                            //     $('.total-profit').text(data[1].profit);
                            //     options.forEach(function(index) {
                            //         var date_format = new Date(index.created_at);
                            //         var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                            //         optionLoop +=
                            //             '<tr><td class="text-center">' + a + '</td><td class="text-center">' + index.account.name + '</td><td class="text-center"><span class="badge  bg-gradient-success"> ' + index.amount_loaded + '$</span></td><td class="text-center">'
                            //             + ((index.type == 'refer')?'bonus':index.type)  + '</td><td class="text-center">' + index.created_by.name + '</td></tr>';
                            //     });
                            // }
                            options.forEach(function(index) {
                                var date_format = new Date(index.created_at),
                                    load = index.type == 'load' ? parseInt(index.amount_loaded) : 0,
                                    redeem = index.type == 'redeem' ? parseInt(index.amount_loaded) : 0;
                                    profitLoss = load - redeem;
                                // console.log(new Date(index.created_at));
                                // console.log(date_format);
                                // var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear()+' '+date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                                var a = date_format.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                                optionLoop +=
                                    '<tr><td class="text-center">' + a + '</td>\
                                    <td class="text-center"><span class="badge  bg-gradient-success"> ' + index.amount_loaded + '$</span></td>\
                                    <td class="text-center">' + index.form.facebook_name + '</td>\
                                    <td class="text-center">' + (profitLoss < 0 ? '<span class="badge bg-gradient-warning">'+profitLoss+'$</span>' : '<span class="badge bg-gradient-success">'+profitLoss+'$</span>') + '</td>\
                                    <td class="text-center">' + index.account.name + '</td>\
                                    <td class="text-center">' + index.form_game.game_id + '</td>\
                                    <td class="text-center">' + ((index.type == 'refer')?'bonus':index.type)  + '</td>\
                                    <td class="text-center">' + index.created_by.name + '</td></tr>';
                            });

                        } else {
                            optionLoop = '<tr><td>No History</td></tr>';
                        }
                        $(".user-history-body").html(optionLoop);

                    },
                    error: function(data) {
                        toastr.error('Error', data.responseText);
                    }
                });
            });
        });
});
