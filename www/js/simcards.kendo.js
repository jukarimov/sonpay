$(document).ready(function (){
  var dataSource = new kendo.data.DataSource({
    pageSize: 10,
    serverPaging: true,
    serverSorting: true,
    serverFiltering: true,
    transport: {
      read: {
        url: '/app/sim/',
        dataType: 'json',
        type: 'GET',
      },
      parameterMap: function(options, operation) {
        var map = {}
        if (operation == 'read') {
          map.page = options.page
          map.rows = options.take
          map.sort = options.sort
          map.filt = options.filter
          map.sqlc = []
          if (map.sort) {
            map.sort = map.sort[0]
            if (map.sort) {
              var t = map.sort
              map.sort = t.field
              map.order = t.dir
            }
          }
          if (map.filt) {
            var filters = map.filt.filters
            for (i in filters) {
              if (filters[i].field) {
                var maplen = map.sqlc.length
                if (i > 0 && map.sqlc[maplen - 1] != 'and' && map.sqlc[maplen - 1] != 'or') {
                  map.sqlc.push(map.filt.logic)
                }
                map.sqlc.push(objunpack(filters[i]))
                if (i < filters.length-1) {
                  map.sqlc.push(map.filt.logic)
                }
              } else {
                var maplen = map.sqlc.length
                if (maplen > 0 && map.sqlc[maplen - 1] != 'and' && map.sqlc[maplen - 1] != 'or') {
                  map.sqlc.push(map.filt.logic)
                }
                map.sqlc.push(objunpack(filters[i].filters[0]))
                map.sqlc.push(objunpack(filters[i].logic))
                map.sqlc.push(objunpack(filters[i].filters[1]))
              }
              f = filters[i]
              if (!f.value || !f.field || !f.operator) {
                //alert('Bad filter value:' + map.sqlc)
                map.sqlc = [];
                return map;
              }
            }
            map.sqlc = map.sqlc.toString()
          }
        }
        return map
      },
    },
    schema: {
      data: function(reply) { 
        var rs = reply.rows
        return rs
      },
      total: function(reply) {
        var tt = reply.total
        return tt
      },
      model: {
        id: "id",
        fields: {
          id: {
            type:       "number",
            editable:   false,
          },
          category: {
            type:       "string",
            editable:   true,
            validation: { required: true }
          },
          published: {
            type:       "date",
            editable:   true,
            validation: { required: true }
          },
          author: {
            type:       "string",
            editable:   true,
            validation: { required: true }
          },
          name: {
            type:       "string",
            editable:   true,
            validation: { required: true }
          },
        },
      },
    },
  })

  $("#grid").kendoGrid({
    dataSource: dataSource,
    navigatable: true,
    pageable: {
	refresh: true,
	pageSizes: [10,20,50,100]
    },
    //height: 500,
    editable: 'popup',
    sortable: true,
    filterable: {
      operators: {
        string: {
          eq: tr('filter.eq'),
          neq: tr('filter.neq'),
          startswith: tr('filter.startswith'),
          endswith: tr('filter.endswith'),
          contains: tr('filter.contains'),
        }
      },
      messages: {
	      info: tr('show items with value that:'),
	      filter: tr('filter'),
	      clear: tr('clear'),
	      and: tr('and'),
	      or: tr('or')
      }
    },
    scrollable: true,
    toolbar: [
      { name: "home", text: "Home" },
      { template: '<input id="operator_list" value="'+tr('select operator')+'"/>' },
      { template: '<input id="category_list" value="'+tr('select category')+'"/>' },
    ],
    columns: [
      { field: "id", title: "ID", width: 50 },
      { field: "operator", title: tr("Operator"), width: 60,  },
      { field: "category", title: tr("Category"), width: 60, },
      { field: "tarif",    title: tr("Tarif"),    width: 150 },
      { field: "number",   title: tr("Number"),   width: 60 },
    ],
  });
  $('.k-grid-home').click(function(){
  	window.location = '/';
  });
  $("#operator_list").kendoDropDownList({
    optionLabel: tr("select operator"),
    dataTextField: "name",
    dataValueField: "operator",
    dataSource: {
          transport: {
            read: {
              url: '/app/sim/operators.php',
              dataType: 'json',
              type: 'GET',
            },
          },
          schema: {
            data: function(reply) { 
              return reply.rows
            },
          },
    },
    change: function() {
      val = $("#operator_list").val();
      var grid = $("#grid").data().kendoGrid;
      if (val != tr('select operator')) {
        grid.dataSource.filter({
          "filters":[{"field":"operator","operator":"eq","value":val}]
        })
      } else {
        grid.dataSource.filter({
          "filters":[{"field":"operator","operator":"eq","value":null}]
        })
      }
    },
    open: function() {
      $("#operator_list").data("kendoDropDownList").dataSource.read()
    }
  });

  $("#category_list").kendoDropDownList({
    optionLabel: tr("select category"),
    dataTextField: "name",
    dataValueField: "name",
    dataSource: {
          transport: {
            read: {
              url: '/app/sim/category.php',
              dataType: 'json',
              type: 'GET',
            },
          },
          schema: {
            data: function(reply) { 
              return reply.rows
            },
          },
    },
    change: function() {
      val = $("#category_list").val();
      var grid = $("#grid").data().kendoGrid;
      if (val != tr('select category')) {
        grid.dataSource.filter({
          "filters":[{"field":"category","operator":"eq","value":val}]
        })
      } else {
        grid.dataSource.filter({
          "filters":[{"field":"category","operator":"eq","value":null}]
        })
      }
    },
    open: function() {
      $("#category_list").data("kendoDropDownList").dataSource.read()
    }
  });/* category_list dropdown */
})
$(window).resize(function(){
  var height = $(window).height()
  $('#grid').height(height - (height/9))
  $('#grid').find(".k-grid-content").height(height - (height/9) - 90)
})
function objunpack(o){
  if (o.field && o.operator && o.value) {
    if (o.field == 'published') {
      var t = o.value
      o.value = Date2MDY(t)
    }
    return [o.field, o.operator, o.value]
  }
  return o
}
function Date2MDY(date) {
  var dmy = '';
  dmy += String(date.getMonth()+1) + '-'
  dmy += String(date.getDate()) + '-'
  dmy += String(date.getFullYear())
  return dmy;
}
function tr(e) {
	var translation = null;
	$.ajax({
		url: '/app/sim/tr.php',
		data: { val: e },
		type: 'POST',
		async: false,
		cache: false,
		timeout: 60*1000,
		success: function(resp){
			if (resp == 'notranslation')
				translation = e;
			else
				translation = resp;
		}
	});
	return translation;
}
