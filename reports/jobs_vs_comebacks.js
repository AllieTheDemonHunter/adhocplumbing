/**
 * Created by allie on 2014/09/16.
 */
//"use strict";
$(function() {
    function check_requirements() {
        var from = $( "#from").val();
        var to = $( "#to").val();
        var date_granularity = $("select[name='date_granularity']").val();

        var report_type = $("select[name='report_type']").val();

        var crew = $("select[name='crews']").val();
        var client = $("select[name='clients']").val();

        var compare = $("select[name='compare']").val();

        var province = $("select[name='provinces']").val();
        var region = $("select[name='regions']").val();
        var suburb = $("select[name='suburbs]").val();

        if(from != "" && to != "") {
            //This return gives data to the getData.
            return {compare: compare,
                    start_date: from,
                    end_date: to,
                    date_granularity: date_granularity,
                    crew: crew,
                    client: client,
                    report_type: report_type,
                    province: province,
                    region: region,
                    suburb: suburb
            };
        } else {
            return false;
        }
    }

    $(".criteria-select select").change(function(){
        var args = check_requirements();
        if(args) {
            getData(args);
        }
    });

    function getData(args) {
        var url = "reports/report_ajax.php";
        var data = {action: "reports", args: args};
        $("svg#loader").fadeIn();
        $.post(url, data, get_data_success, "json");
    }

    function get_data_success(data, status, jqXHR) {
        console.log(data, data.title);
        success_crews(data.crews, data.selected_crew);
        success_clients(data.clients, data.selected_client);
        success_provinces(data.provinces, data.selected_province);
        success_regions(data.regions, data.selected_region);
        print_chart(data.title, data.chart_id, data.chart_data, data.x_label);
        $("svg#loader").fadeOut();
        $("#screen").fadeOut("slow");
    }

    function print_chart(title, chart_id, chart_data, x_label) {
        $("#container").prepend(title + '<div id="'+chart_id+'" class="chart-and-table"><div class="chart"></div><div class="table"></div></div>');
        var chart = c3.generate({
            bindto: '#container div#'+chart_id+' .chart',
            data: {
                columns: chart_data.values,
                type: $("select[name='chart_types']").val()
            },
            axis: {
                x: {
                    type: 'category',
                    categories: chart_data.names,
                    label: x_label,
                    tick: {
                        rotate: 75
                    },
                    height: 70
                },
                y: {
                    label: 'Jobs'
                }
            },
            bar: {
                width: {
                    ratio: 0.5 // this makes bar width 50% of length between ticks
                }
                // or
                //width: 100 // this makes bar width 100px
            },
            transition: { duration: 2000 }
        });
        print_table(title, chart_data, chart_id);
    }

    $( "#from" ).datepicker({
        defaultDate: "-1w",
        changeMonth: true,
        numberOfMonths: 1,
        minDate: "2012-09-01",
        dateFormat: "yy-mm-dd",
        onClose: function( selectedDate ) {
            $( "#to" ).datepicker( "option", "minDate", selectedDate );
            var args = check_requirements();
            if(args) {
                getData(args);
            }
        }
    });

    $( "#to" ).datepicker({
        defaultDate: "-1d",
        changeMonth: true,
        numberOfMonths: 1,
        maxDate: "today",
        dateFormat: "yy-mm-dd",
        onClose: function( selectedDate ) {
            $( "#from" ).datepicker( "option", "maxDate", selectedDate );

            var args = check_requirements();
            if(args) {
                getData(args);
            }
        }
    });

    $("h3").click(function() {
            $(".c3").slideUp();
        $(this.target).next("div.c3").slideDown();
    });

    function success_crews(crews, selected) {
        $("#crews option").detach();
        var option = '<option value="*">All</option>';
        $("#crews select").append(option);
        $.each(crews, populate_select_crews);
        $("#crews").show();
    }

    function success_provinces(provinces, selected) {
        $("#provinces option").detach();
        var option = '<option value="*">All</option>';
        $("#provinces select").append(option);
        $.each(provinces, populate_select_provinces);
    }

    function success_regions(regions, selected) {
        $("#regions option").detach();
        var option = '<option value="*">All</option>';
        $("#regions select").append(option);
        $.each(regions, populate_select_regions);
    }

    function success_clients(clients, selected) {
        $("#clients option").detach();
        var option = '<option value="*">All</option>';
        $("#clients select").append(option);
        $.each(clients, populate_select_clients);
        $("#clients").show();
    }

    function populate_select_crews(property_name, value_object) {
        if (value_object.count > 0) {
            if (get_data_success.arguments[0].selected_crew && get_data_success.arguments[0].selected_crew == value_object.crew_name) {
                var selected = "selected";
            } else {
                var selected = "";
            }
            var option = '<option value="' + value_object.crew_name + '" ' + selected + '>' + value_object.crew_name + ' (' + value_object.count + ')' + '</option>';
            $("#crews select").append(option);
        }
    }

    function populate_select_clients(property_name, value_object) {
        if (value_object.count > 0) {
            if (get_data_success.arguments[0].selected_client && get_data_success.arguments[0].selected_client == value_object.client_name) {
                var selected = "selected";
            } else {
                var selected = "";
            }
            var option = '<option value="' + value_object.client_name + '" ' + selected + '>' + value_object.client_name + ' (' + value_object.count + ')' + '</option>';
            $("#clients select").append(option);
        }
    }

    function populate_select_provinces(property_name, value_object) {
        if (value_object.count > 0) {
            if (get_data_success.arguments[0].selected_province && get_data_success.arguments[0].selected_province == value_object.province) {
                var selected = "selected";
            } else {
                var selected = "";
            }
            var option = '<option value="' + value_object.province + '" ' + selected + '>' + value_object.province + ' (' + value_object.count + ')' + '</option>';
            $("#provinces select").append(option);
        }
    }

    function populate_select_regions(property_name, value_object) {
        if (value_object.count > 0) {
            if (get_data_success.arguments[0].selected_region && get_data_success.arguments[0].selected_region == value_object.region) {
                var selected = "selected";
            } else {
                var selected = "";
            }
            var option = '<option value="' + value_object.region + '" ' + selected + '>' + value_object.region + ' (' + value_object.count + ')' + '</option>';
            $("#regions select").append(option);
        }
    }

    function print_table(title, table_data, chart_id) {
        var column_names = new Array('Date');
        var values = table_data.values;
        for(z = 0; z < values.length; ++z) {
            column_names.push(values[z][0]);
        }
        var rows = new Array;
        for(x = 0; x < (values[0].length-1); ++x) {
            var name = table_data.names.shift();
            var row = new Array(name);
            for(a = 0; a < (values.length); ++a) {
                row.push(values[a][(x+1)]);
            }
            rows.push(row);
        }

        $('#container div#'+chart_id+' .table')
            .TidyTable({
                columnTitles : column_names,
                columnValues : rows
            });
        };
});