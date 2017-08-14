/*
 *  Get State Function 
 *  For Drop down box
 */
function getState(id)
{
    $.ajax({
        type: "POST",
        url: base_url + "user/getState",
        data: {
            "id": id
        },
        success: function(response)
        {
            //alert(response);
            $("select[name=state]").html("");
            var obj = $.parseJSON(response);
            $.each(obj, function(i, v) {
                var element = '<option value="' + v.stateShortName + '">' + v.stateName + '</option>';
                $("select[name=state]").append(element);
            })
            $("select[name=state]").prepend('<option value="" selected="selected">-Please Select-</option>');
        }
    });
}
function getCity(id)
{
    $.ajax({
        type: "POST",
        url: base_url + "user/getCity",
        data: {
            "id": id
        },
        success: function(response)
        {
            //alert(response);
            $("select[name=city]").html("");
            $("select[name=city]").html('<option value="">-Please Select-</option>');
            var obj = $.parseJSON(response);
            $.each(obj, function(i, v) {
                var element = '<option value="' + v.cityId + '">' + v.cityName + '</option>';
                $("select[name=city]").append(element);
            })
        }
    });
}
function getClientList(id)
{
    $.ajax({
        type: "POST",
        url: base_url + "client/getClient",
        data: {
            "id": id
        },
        success: function(response)
        {
            //alert(response);
            $("select[name=client]").html("");
            $("select[name=client]").html('<option value="">-Please Select-</option>');
            var obj = $.parseJSON(response);
            $.each(obj, function(i, v) {
                var element = '<option value="' + v.clientId + '">' + v.clientFirstName + " " + v.clientLastName + '</option>';
                $("select[name=client]").append(element);
            })
        }
    });
}
function validateUpDelForm()
{

    if ($('.checkArea').find('input[type=checkbox]:checked').length == 0)
    {
        alert('Please Select Atleast One Item');

        return false;
    }


}
function sendMail()
{
    //alert("a");
    if ($('.checkArea').find('input[type=checkbox]:checked').length == 0)
    {
        alert('Please select atleast one client');
    }
    else
    {
        var checkedValues = $('.checkArea input:checkbox:checked').map(function() {
            return this.value;
        }).get();

        var subject = $("input[name=subject]");
        var details = $("div[id=sendMsgWriteArea]");

        //alert(details);

        var error = 0;

        if ($.trim(subject.val()) == "")
        {
            subject.attr("placeholder", "Enter mail subject");
            subject.css("border", "1px solid red");
            error = 1;
        }
        else
        {
            subject.removeAttr("placeholder");
            subject.css("border", "1px solid #CCC");
        }
        if (details.html() == "")
        {
            details.css("border", "1px solid red");
            error = 1;
        }
        else
        {
            details.css("border", "1px solid #CCC");
        }
        //alert(checkedValues);

        if (error == 0) {
            $("div[id=mailStatus]").show().html("Please wait.....");
            $.ajax({
                type: "POST",
                url: base_url + "client/sendMail",
                data: {
                    "id": checkedValues,
                    "subject": subject.val(),
                    "body": details.html(),
                    "submit": "1"
                },
                success: function(res)
                {
                    if (res == '1')
                    {
                        subject.val("");
                        details.html("");
                        $("div[id=mailStatus]").show().html("Mail Successfully Sent");

                        setTimeout(function() {
                            $("div[id=mailStatus]").hide().html("");
                            $("button[class=close]").trigger("click");
                        }, 4000)
                    }
                }
            })
        }
    }
}

function sendMailCompany()
{
    //alert("a");
    if ($('.checkArea').find('input[type=checkbox]:checked').length == 0)
    {
        alert('Please select atleast one company');
    }
    else
    {
        var checkedValues = $('.checkArea input:checkbox:checked').map(function() {
            return this.value;
        }).get();

        var subject = $("input[name=subject]");
        var details = $("div[id=sendMsgWriteArea]");

        //alert(details);

        var error = 0;

        if ($.trim(subject.val()) == "")
        {
            subject.attr("placeholder", "Enter mail subject");
            subject.css("border", "1px solid red");
            error = 1;
        }
        else
        {
            subject.removeAttr("placeholder");
            subject.css("border", "1px solid #CCC");
        }
        if (details.html() == "")
        {
            details.css("border", "1px solid red");
            error = 1;
        }
        else
        {
            details.css("border", "1px solid #CCC");
        }
        //alert(checkedValues);

        if (error == 0) {
            $("div[id=mailStatus]").show().html("Please wait.....");
            $.ajax({
                type: "POST",
                url: base_url + "company/sendMail",
                data: {
                    "id": checkedValues,
                    "subject": subject.val(),
                    "body": details.html(),
                    "submit": "1"
                },
                success: function(res)
                {
                    if (res == '1')
                    {
                        subject.val("");
                        details.html("");
                        $("div[id=mailStatus]").show().html("Mail Successfully Sent");

                        setTimeout(function() {
                            $("div[id=mailStatus]").hide().html("");
                            $("button[class=close]").trigger("click");
                        }, 4000)
                    }
                }
            })
        }
    }
}
function sendMailProject()
{
    //alert("a");
    if ($('.checkArea').find('input[type=checkbox]:checked').length == 0)
    {
        alert('Please select atleast one project');
    }
    else
    {
        var checkedValues = $('.checkArea input:checkbox:checked').map(function() {
            return this.value;
        }).get();

        var subject = $("input[name=subject]");
        var details = $("div[id=sendMsgWriteArea]");

        //alert(details);

        var error = 0;

        if ($.trim(subject.val()) == "")
        {
            subject.attr("placeholder", "Enter mail subject");
            subject.css("border", "1px solid red");
            error = 1;
        }
        else
        {
            subject.removeAttr("placeholder");
            subject.css("border", "1px solid #CCC");
        }
        if (details.html() == "")
        {
            details.css("border", "1px solid red");
            error = 1;
        }
        else
        {
            details.css("border", "1px solid #CCC");
        }
        //alert(checkedValues);

        if (error == 0) {
            $("div[id=mailStatus]").show().html("Please wait.....");
            $.ajax({
                type: "POST",
                url: base_url + "project/sendMail",
                data: {
                    "id": checkedValues,
                    "subject": subject.val(),
                    "body": details.html(),
                    "submit": "1"
                },
                success: function(res)
                {
                    if (res == '1')
                    {
                        subject.val("");
                        details.html("");
                        $("div[id=mailStatus]").show().html("Mail Successfully Sent");

                        setTimeout(function() {
                            $("div[id=mailStatus]").hide().html("");
                            $("button[class=close]").trigger("click");
                        }, 4000)
                    }
                }
            })
        }
    }
}

function sentMailToSingleClient(email)
{
    //alert(email);
    var subject = $("input[name=s-subject]");
    var details = $("div[id=s-sendMsgWriteArea]");

    //alert(details);

    var error = 0;

    if ($.trim(subject.val()) == "")
    {
        subject.attr("placeholder", "Enter mail subject");
        subject.css("border", "1px solid red");
        error = 1;
    }
    else
    {
        subject.removeAttr("placeholder");
        subject.css("border", "1px solid #CCC");
    }
    if (details.html() == "")
    {
        details.css("border", "1px solid red");
        error = 1;
    }
    else
    {
        details.css("border", "1px solid #CCC");
    }
    //alert(checkedValues);

    if (error == 0) {
        $("div[id=s-mailStatus]").show().html("Please wait.....");
        $.ajax({
            type: "POST",
            url: base_url + "client/sendMailSingleClient",
            data: {
                "subject": subject.val(),
                "body": details.html(),
                "email": email,
                "submit": "1"
            },
            success: function(res)
            {
                if (res == '1')
                {
                    subject.val("");
                    details.html("");
                    $("div[id=s-mailStatus]").show().html("Mail Successfully Sent");

                    setTimeout(function() {
                        $("div[id=s-mailStatus]").hide().html("");
                        $("button[class=close]").trigger("click");
                    }, 4000)
                }
            }
        })
    }
}
function sentMailToSingleCompany(email)
{
    //alert(email);
    var subject = $("input[name=s-subject]");
    var details = $("div[id=s-sendMsgWriteArea]");

    //alert(details);

    var error = 0;

    if ($.trim(subject.val()) == "")
    {
        subject.attr("placeholder", "Enter mail subject");
        subject.css("border", "1px solid red");
        error = 1;
    }
    else
    {
        subject.removeAttr("placeholder");
        subject.css("border", "1px solid #CCC");
    }
    if (details.html() == "")
    {
        details.css("border", "1px solid red");
        error = 1;
    }
    else
    {
        details.css("border", "1px solid #CCC");
    }
    //alert(checkedValues);

    if (error == 0) {
        $("div[id=s-mailStatus]").show().html("Please wait.....");
        $.ajax({
            type: "POST",
            url: base_url + "company/sendMailSingleCompany",
            data: {
                "subject": subject.val(),
                "body": details.html(),
                "email": email,
                "submit": "1"
            },
            success: function(res)
            {
                if (res == '1')
                {
                    subject.val("");
                    details.html("");
                    $("div[id=s-mailStatus]").show().html("Mail Successfully Sent");

                    setTimeout(function() {
                        $("div[id=s-mailStatus]").hide().html("");
                        $("button[class=close]").trigger("click");
                    }, 4000)
                }
            }
        })
    }
}
function sentMailToSingleProject(email)
{
    //alert(email);
    var subject = $("input[name=s-subject]");
    var details = $("div[id=s-sendMsgWriteArea]");

    //alert(details);

    var error = 0;

    if ($.trim(subject.val()) == "")
    {
        subject.attr("placeholder", "Enter mail subject");
        subject.css("border", "1px solid red");
        error = 1;
    }
    else
    {
        subject.removeAttr("placeholder");
        subject.css("border", "1px solid #CCC");
    }
    if (details.html() == "")
    {
        details.css("border", "1px solid red");
        error = 1;
    }
    else
    {
        details.css("border", "1px solid #CCC");
    }
    //alert(checkedValues);

    if (error == 0) {
        $("div[id=s-mailStatus]").show().html("Please wait.....");
        $.ajax({
            type: "POST",
            url: base_url + "project/sentMailToSingleProject",
            data: {
                "subject": subject.val(),
                "body": details.html(),
                "email": email,
                "submit": "1"
            },
            success: function(res)
            {
                if (res == '1')
                {
                    subject.val("");
                    details.html("");
                    $("div[id=s-mailStatus]").show().html("Mail Successfully Sent");

                    setTimeout(function() {
                        $("div[id=s-mailStatus]").hide().html("");
                        $("button[class=close]").trigger("click");
                    }, 4000)
                }
            }
        })
    }
}
function sentMailToPlot(id)
{
    //alert(email);
    var subject = $("input[name=s-subject]");
    var details = $("div[id=s-sendMsgWriteArea]");

    //alert(details);

    var error = 0;

    if ($.trim(subject.val()) == "")
    {
        subject.attr("placeholder", "Enter mail subject");
        subject.css("border", "1px solid red");
        error = 1;
    }
    else
    {
        subject.removeAttr("placeholder");
        subject.css("border", "1px solid #CCC");
    }
    if (details.html() == "")
    {
        details.css("border", "1px solid red");
        error = 1;
    }
    else
    {
        details.css("border", "1px solid #CCC");
    }
    //alert(checkedValues);

    if (error == 0) {
        $("div[id=s-mailStatus]").show().html("Please wait.....");
        $.ajax({
            type: "POST",
            url: base_url + "plot/sentMailToPlot",
            data: {
                "subject": subject.val(),
                "body": details.html(),
                "id": id,
                "submit": "1"
            },
            success: function(res)
            {
                if (res == '1')
                {
                    subject.val("");
                    details.html("");
                    $("div[id=s-mailStatus]").show().html("Mail Successfully Sent");

                    setTimeout(function() {
                        $("div[id=s-mailStatus]").hide().html("");
                        $("button[class=close]").trigger("click");
                    }, 4000)
                }
            }
        })
    }
}
function sendMailPlot(id)
{
    //alert("a");
    if ($('.checkArea').find('input[type=checkbox]:checked').length == 0)
    {
        alert('Please select atleast one project');
    }
    else
    {
        var checkedValues = $('.checkArea input:checkbox:checked').map(function() {
            return this.value;
        }).get();

        var subject = $("input[name=subject]");
        var details = $("div[id=sendMsgWriteArea]");

        //alert(details);

        var error = 0;

        if ($.trim(subject.val()) == "")
        {
            subject.attr("placeholder", "Enter mail subject");
            subject.css("border", "1px solid red");
            error = 1;
        }
        else
        {
            subject.removeAttr("placeholder");
            subject.css("border", "1px solid #CCC");
        }
        if (details.html() == "")
        {
            details.css("border", "1px solid red");
            error = 1;
        }
        else
        {
            details.css("border", "1px solid #CCC");
        }
        //alert(checkedValues);

        if (error == 0) {
            $("div[id=mailStatus]").show().html("Please wait.....");
            $.ajax({
                type: "POST",
                url: base_url + "plot/sentMailToMultiplePlot",
                data: {
                    "id": checkedValues,
                    "subject": subject.val(),
                    "body": details.html(),
                    "submit": "1"
                },
                success: function(res)
                {
                    if (res == '1')
                    {
                        subject.val("");
                        details.html("");
                        $("div[id=mailStatus]").show().html("Mail Successfully Sent");

                        setTimeout(function() {
                            $("div[id=mailStatus]").hide().html("");
                            $("button[class=close]").trigger("click");
                        }, 4000)
                    }
                }
            })
        }
    }
}
function sentMailToApartment(id)
{
    //alert(email);
    var subject = $("input[name=s-subject]");
    var details = $("div[id=s-sendMsgWriteArea]");

    //alert(details);

    var error = 0;

    if ($.trim(subject.val()) == "")
    {
        subject.attr("placeholder", "Enter mail subject");
        subject.css("border", "1px solid red");
        error = 1;
    }
    else
    {
        subject.removeAttr("placeholder");
        subject.css("border", "1px solid #CCC");
    }
    if (details.html() == "")
    {
        details.css("border", "1px solid red");
        error = 1;
    }
    else
    {
        details.css("border", "1px solid #CCC");
    }
    //alert(checkedValues);

    if (error == 0) {
        $("div[id=s-mailStatus]").show().html("Please wait.....");
        $.ajax({
            type: "POST",
            url: base_url + "apartment/sentMailToApartment",
            data: {
                "subject": subject.val(),
                "body": details.html(),
                "id": id,
                "submit": "1"
            },
            success: function(res)
            {
                if (res == '1')
                {
                    subject.val("");
                    details.html("");
                    $("div[id=s-mailStatus]").show().html("Mail Successfully Sent");

                    setTimeout(function() {
                        $("div[id=s-mailStatus]").hide().html("");
                        $("button[class=close]").trigger("click");
                    }, 4000)
                }
            }
        })
    }
}
function sendMailApartment()
{
    //alert("a");
    if ($('.checkArea').find('input[type=checkbox]:checked').length == 0)
    {
        alert('Please select atleast one project');
    }
    else
    {
        var checkedValues = $('.checkArea input:checkbox:checked').map(function() {
            return this.value;
        }).get();

        var subject = $("input[name=subject]");
        var details = $("div[id=sendMsgWriteArea]");

        //alert(details);

        var error = 0;

        if ($.trim(subject.val()) == "")
        {
            subject.attr("placeholder", "Enter mail subject");
            subject.css("border", "1px solid red");
            error = 1;
        }
        else
        {
            subject.removeAttr("placeholder");
            subject.css("border", "1px solid #CCC");
        }
        if (details.html() == "")
        {
            details.css("border", "1px solid red");
            error = 1;
        }
        else
        {
            details.css("border", "1px solid #CCC");
        }
        //alert(checkedValues);

        if (error == 0) {
            $("div[id=mailStatus]").show().html("Please wait.....");
            $.ajax({
                type: "POST",
                url: base_url + "apartment/sentMailToMultipleApartment",
                data: {
                    "id": checkedValues,
                    "subject": subject.val(),
                    "body": details.html(),
                    "submit": "1"
                },
                success: function(res)
                {
                    if (res == '1')
                    {
                        subject.val("");
                        details.html("");
                        $("div[id=mailStatus]").show().html("Mail Successfully Sent");

                        setTimeout(function() {
                            $("div[id=mailStatus]").hide().html("");
                            $("button[class=close]").trigger("click");
                        }, 4000)
                    }
                }
            })
        }
    }
}

function sendMailCommercial()
{
    //alert("a");
    if ($('.checkArea').find('input[type=checkbox]:checked').length == 0)
    {
        alert('Please select atleast one project');
    }
    else
    {
        var checkedValues = $('.checkArea input:checkbox:checked').map(function() {
            return this.value;
        }).get();

        var subject = $("input[name=subject]");
        var details = $("div[id=sendMsgWriteArea]");

        //alert(details);

        var error = 0;

        if ($.trim(subject.val()) == "")
        {
            subject.attr("placeholder", "Enter mail subject");
            subject.css("border", "1px solid red");
            error = 1;
        }
        else
        {
            subject.removeAttr("placeholder");
            subject.css("border", "1px solid #CCC");
        }
        if (details.html() == "")
        {
            details.css("border", "1px solid red");
            error = 1;
        }
        else
        {
            details.css("border", "1px solid #CCC");
        }
        //alert(checkedValues);

        if (error == 0) {
            $("div[id=mailStatus]").show().html("Please wait.....");
            $.ajax({
                type: "POST",
                url: base_url + "commercial/sentMailToMultipleCommercial",
                data: {
                    "id": checkedValues,
                    "subject": subject.val(),
                    "body": details.html(),
                    "submit": "1"
                },
                success: function(res)
                {
                    if (res == '1')
                    {
                        subject.val("");
                        details.html("");
                        $("div[id=mailStatus]").show().html("Mail Successfully Sent");

                        setTimeout(function() {
                            $("div[id=mailStatus]").hide().html("");
                            $("button[class=close]").trigger("click");
                        }, 4000)
                    }
                }
            })
        }
    }
}

function sentMailToCommercial(id)
{
    //alert(email);
    var subject = $("input[name=s-subject]");
    var details = $("div[id=s-sendMsgWriteArea]");

    //alert(details);

    var error = 0;

    if ($.trim(subject.val()) == "")
    {
        subject.attr("placeholder", "Enter mail subject");
        subject.css("border", "1px solid red");
        error = 1;
    }
    else
    {
        subject.removeAttr("placeholder");
        subject.css("border", "1px solid #CCC");
    }
    if (details.html() == "")
    {
        details.css("border", "1px solid red");
        error = 1;
    }
    else
    {
        details.css("border", "1px solid #CCC");
    }
    //alert(checkedValues);

    if (error == 0) {
        $("div[id=s-mailStatus]").show().html("Please wait.....");
        $.ajax({
            type: "POST",
            url: base_url + "commercial/sentMailToCommercial",
            data: {
                "subject": subject.val(),
                "body": details.html(),
                "id": id,
                "submit": "1"
            },
            success: function(res)
            {
                if (res == '1')
                {
                    subject.val("");
                    details.html("");
                    $("div[id=s-mailStatus]").show().html("Mail Successfully Sent");

                    setTimeout(function() {
                        $("div[id=s-mailStatus]").hide().html("");
                        $("button[class=close]").trigger("click");
                    }, 4000)
                }
            }
        })
    }
}
function getClientAndProjectByCompany(id, projectId)
{
    $.ajax({
        type: "POST",
        url: base_url + "plot/getCompanyProjectNclient",
        data: {
            "id": id,
            "submit": "1"
        },
        success: function(res)
        {
            var obj = $.parseJSON(res);
            $("select[name=project]").html("");
            $.each(obj.project, function(i, v) {
                if (v.id != projectId) {
                    var element = '<option value="' + v.id + '">' + v.projectName + '</option>';
                    $("select[name=project]").append(element);
                }
            })
            $("select[name=project]").prepend('<option value="" selected="selected">-Please Select-</option>');

            $("select[name=client]").html("");
            $.each(obj.client, function(i, v) {
                var element = '<option value="' + v.clientId + '">' + v.clientFirstName + '</option>';
                $("select[name=client]").append(element);
            })
            $("select[name=client]").prepend('<option value="" selected="selected">-Please Select-</option>');
        }
    })
}
function calculateInstallment(value)
{
    var dp = $("input[name=down-payment]");
    var mp = $("input[name=monthly-payment]");
    var askingPrice = $("input[name=sub-total]");
    var ip = $("select[name=installment-period]");

    if (dp.val() < askingPrice) {
        if ($.trim(dp.val()) != "") {

            if (!isNaN(dp.val()) && !isNaN(askingPrice.val()))
            {
                var due = askingPrice.val() - dp.val();
                //alert(due);
                var ins = parseFloat(due) / parseFloat(value);
                mp.val(ins);
            }
        }
    }


}


