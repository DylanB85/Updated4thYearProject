scheduler.config.xml_date="%Y-%m-%d %H:%i";
scheduler.config.first_hour = 0;
scheduler.config.last_hour = 24;
scheduler.config.limit_time_select = true;
scheduler.config.details_on_create = true;

scheduler.config.select = false;
scheduler.config.details_on_dblclick = true;
scheduler.config.max_month_events = 5;
scheduler.config.resize_month_events = true;


scheduler.config.lightbox.sections = [
    {name:"Title", height:30, map_to:"text", type:"textarea"},
    {name:"Description", height:30, map_to:"description", type:"textarea"},
    {name: "Category", options: window.GLOBAL_CATEGORIES, map_to: "category", type: "select", height:30},
    {name:"time", height:72, type:"time", map_to:"auto"}
];


var initSettings = {
    elementId: "scheduler_element",
    startDate: new Date(),
    mode: "week"
};

scheduler.init(initSettings.elementId, initSettings.startDate , initSettings.mode);

//Parse initial appointments
scheduler.parse(window.GLOBAL_APPOINTMENTS, "json");

//Function that formats the events to the expected format in the server side

/**
 * Returns an Object with the desired structure of the server.
 * @param {*} id
 * @param {*} useJavascriptDate
 */
function getFormatedEvent(id, useJavascriptDate){
    var event;

    // If id is already an event object, use it and don't search for it
    if(typeof(id) == "object"){
        event = id;
    }else{
        event = scheduler.getEvent(parseInt(id));
    }

    if(!event){
        console.error("The ID of the event doesn't exist: " + id);
        return false;
    }

    var start , end;

    if(useJavascriptDate){
        start = event.start_date;
        end = event.end_date;
    }else{
        start = moment(event.start_date).format('DD-MM-YYYY HH:mm:ss');
        end = moment(event.end_date).format('DD-MM-YYYY HH:mm:ss');
    }

    return {
        id: event.id,
        start_date : start,
        end_date : end,
        description : event.description,
        title : event.text,
        category: event.category
    };
}

/**
 * Handle the CREATE scheduler event
 */
scheduler.attachEvent("onEventAdded", function(id,ev){
    var schedulerState = scheduler.getState();

    $.ajax({
        url:  window.GLOBAL_SCHEDULER_ROUTES.create,
        data: getFormatedEvent(ev),
        dataType: "json",
        type: "POST",
        success: function(response){
            // Very important:
            // Update the ID of the scheduler appointment with the ID of the database
            // so we can edit the same appointment now !

            scheduler.changeEventId(ev.id , response.id);

            alert('Appointment '+ev.text+ " has been created! Good Luck!");
        },
        error:function(error){
            alert('Error: The following appointment '+ev.text+ 'please report to an admin');
            console.log(error);
        }
    });
});

/**
 * Handle the UPDATE event of the scheduler
 */
scheduler.attachEvent("onEventChanged", function(id,ev){
    $.ajax({
        url:  window.GLOBAL_SCHEDULER_ROUTES.update,
        data: getFormatedEvent(ev),
        dataType: "json",
        type: "POST",
        success: function(response){
            if(response.status == "success"){
                alert("Appointment Updated!");
            }
        },
        error: function(err){
            alert("Error: Cannot save changes, try again or report to Admin");
            console.error(err);
        }
    });

    return true;
});

/**
 * Handle the DELETE appointment event
 */
scheduler.attachEvent("onConfirmedBeforeEventDelete",function(id,ev){
    $.ajax({
        url: window.GLOBAL_SCHEDULER_ROUTES.delete,
        data:{
            id: id
        },
        dataType: "json",
        type: "DELETE",
        success: function(response){
            if(response.status == "success"){
                if(!ev.willDeleted){
                    alert("Appointment succesfully deleted");
                }
            }else if(response.status == "error"){
                alert("Error: Cannot delete appointment");
            }
        },
        error:function(error){
            alert("Error: Cannot delete appointment: " + ev.text);
            console.log(error);
        }
    });

    return true;
});