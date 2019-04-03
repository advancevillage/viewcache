var glo_charset=null;
var char_arr=new Array('UTF-8','GBK','GB2312','GB18030','Latin-1');

$(function() {
    $("#keybut").click(function() {
        if ($("#keyquery").val() == "") {
            alert(nokey);
            return;
        } else {
        	glo_charset=$("#selcharset").val();
            $.ajax({
                type: "POST",
                data: data2json(),
                url: "../apps/MemGet.php?type=" + type + "&num=" + num + "&charset=" + glo_charset,
                beforeSend: function() {
                    $("#showres").html("<div id=\"loading\"><img src=\"../images/loading.gif\" width=\"16\" height=\"16\" />" + loading + "</div>");
                },
                success: function(d) {
                    if (d == 'Fail' || d == 'NoLogin' || d == 'ConnectFail') {
                        alert(d);
                        return;
                    } else {
                        var p = eval("(" + d + ")");
                        if (p == "")
                          $("#showres").html("<div id=\"nolist\">" + notget + "</div>");
                        else {
                            $("#showres").html("<div id=\"querytit\"><div id=\"showtit\">" + getres + "</div><div id=\"showimp\">" + resnot + "</div></div>");
                            $.each(p,function(key, value) {
                                if (value === false)
                                  var showvalue = "<span class=\"valuefail\">" + valuefail + "</span>";
                                else 
                                  var showvalue = "<ul>" + toHTML(value,"") + "</ul>";
                                key=htmlspecialchars(key);
								var key_md5=$.md5(encodeURI(key));
                                var strout = "<div class=\"showvalue key_" + key_md5 + "\"><div class=\"keyandflags\"><div class=\"thekey\"><span class=\"keytit\">KEY : </span><span class=\"keycon\">" + decodeURIComponent(key) + "</span></div></div><div class=\"thevalue\"><span class=\"valuespan\">" + showvalue + "</span></div><div class=\"valuemenu\"><div class=\"menulist\"><a class=\"updater\" href=\"javascript:updateres('" + key_md5 + "');\">" + updatetit + "</a></div></div></div>";
                                $("#showres").append(strout);
                            });
                        }
                    }
                    $(".selcharset_c").change(function() {
                    	changecs($(this).val(),$(this).attr('pmd5'));
                	});
                }
            });
        }
    });
});


function refresh(key_md5) {
	var cs=$("#pselcharset_"+key_md5).val();
    $.ajax({
        type: "POST",
        data: formatjsons(key_md5),
        url: "../apps/FormatValue.php?action=refresh&type=" + type + "&num=" + num,
        success: function(d) {
            if (d == 'Fail' || d == 'NoLogin' || d == 'ConnectFail') {
                alert("Fail: \n" + d);
                return;
            } else {
                var p = eval("(" + d + ")");
                if (p == "")
                    $("#showres").html("<div id=\"nolist\">" + notget + "</div>");
                else {
                    $("#showres").html("<div id=\"querytit\"><div id=\"showtit\">" + getres + "</div><div id=\"showimp\">" + resnot + "</div></div>");
                    $.each(p,function(key, value) {
                        if (value === false)
                            var showvalue = "<span class=\"valuefail\">" + valuefail + "</span>";
                        else
                            var showvalue = "<ul>" + toHTML(value,"") + "</ul>";
                        key=htmlspecialchars(key);
                        var key_md5=$.md5(encodeURI(key));
                        var strout = "<div class=\"showvalue key_" + key_md5 + "\"><div class=\"keyandflags\"><div class=\"thekey\"><span class=\"keytit\">KEY : </span><span class=\"keycon\">" + decodeURIComponent(key) + "</span></div></div><div class=\"thevalue\"><span class=\"valuespan\">" + showvalue + "</span></div><div class=\"valuemenu\"><div class=\"menulist\"><a class=\"updater\" href=\"javascript:updateres('" + key_md5 + "');\">" + updatetit + "</a></div></div></div>";
                        $("#showres").append(strout);
                    });
                }
            }
        }
    });
}
function data2json(t) {
    var k = $("#keyquery").val();
    var kr = k.replace(/\'/g, '_ _rd');
    kr = kr.replace(/\\/g, '_ _rx');
    var jsonstr = "{'data':[{'key':'" + kr + "'}]}";
    var p = eval("(" + jsonstr + ")");
    return p;
}
function formatjsons(key_md5) {
    key = $(".key_" + key_md5).find(".keycon").text();
    var kr = key.replace(/\'/g, '_ _rd');
    kr = kr.replace(/\\/g, '_ _rx');
    var jsonstr = "{'data':[{'key':'" + kr + "'}]}";
    var p = eval("(" + jsonstr + ")");
    return p;
}

function htmlspecialchars(str)  {  
    str=str.toString();
    str = str.replace(/&/g, '&amp;');
    str = str.replace(/</g, '&lt;');
    str = str.replace(/>/g, '&gt;');
    str = str.replace(/"/g, '&quot;');
    str = str.replace(/'/g, '&#039;');
    return str;
}

function toHTML(data, key){
    var str = "";
    key = key.toString();
    if (key.length == 0){
        key = "";
    }else {
        key = "<label style='color: black;font-weight: bolder;'>" + key + "</label><label style='color: black;font-weight: bolder'>:&emsp;</label>";
    }
    if ( typeof data == "string"){
        str = "<li style='list-style: none'>" + key + data + "</li>";
    }else if (typeof data == "number") {
        str = "<li style='list-style: none'>" + key +  data.toString() + "</li>";
    }else if (typeof data == "object") {
        str += key;
        str += "<ul>";
        for (var i in data) {
            str += toHTML(data[i], i);
        }
        str += "</ul>";
    }else if (typeof data == "boolean") {
        str = "<li style='list-style: none'>" + key + data.toString() + "</li>";
    }else {
        str="";
    }
    return str;
}

function updateres(key_md5) {
    refresh(key_md5);
}