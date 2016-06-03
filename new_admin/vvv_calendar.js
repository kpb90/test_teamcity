 
var calendars = []; // all calendars 
var mounth_str = ['€нварь','февраль','март','апрель','май','июнь','июль','август','сент€брь','окт€брь','но€брь','декабрь'];

function calendar_create(atarget) {
    if (!atarget)
        return cal_error("ќшибка создани€ календар€: не задано поле ввода");
    if (atarget.value == null)
        return cal_error("ќшибка создани€ календар€: задано неверное поле ввода");
	this.target=atarget;
	this.popup=calendar_popup;	
    this.id = calendars.length;
    calendars[this.id]=this;	
}

function writeday(doc,anid,y,m,d,dow) {
	mm=1*m; if (mm<10) mm="0"+mm;
	dd=1*d; if (dd<10) dd="0"+dd;
	doc.write('\r\n<A href="#" onclick="javascript:opener.calendars['+anid+'].target.value=\''+dd+'.'+mm+'.'+y+'\'; window.close(); return false;"><b> &nbsp; '+d+' &nbsp; </b></a>');
}

function forwardback(doc,anid,y,m,txt) {
	ms=1*m;
	if (ms>12) { ms=1; y++; }
	if (ms<1) { ms=12; y--; }
	if (ms<10) ms="0"+ms;
	doc.write('\r\n<td bgcolor=silver><A href="#" onclick="javascript:opener.calendars['+anid+'].target.value=\'01.'+ms+'.'+y+'\'; opener.calendars['+anid+'].popup(); return false;">'+txt+'</a></td><!--- jаvа cаlendаr by ¬€чеслав Hеѕалыч ¬oroda ICQ: lll-75l-3ll http://bоrоda.yard.ru --->');
}

function calendar_popup(fromx) {
	var obj_calwindow =0;
	var temp_date = new Date();
	var tday = temp_date.getDate();
	var	tmonth = temp_date.getMonth()+1;
	var tyear = temp_date.getYear();
	var tdate=tday+"."+tmonth+"."+tyear;

	var str_date = this.target.value;
    var arr_date = str_date.split('-');
	if (arr_date.length != 3) { arr_date = str_date.split('.'); };	
    if (arr_date.length != 3) { arr_date = tdate.split('.');};
	obj_calwindow= window.open('',' алендарь','width=220,height=160 status=no,location=no,resizable=no,top=200,left=220,dependent=yes,alwaysRaised=yes');
	dd=1*arr_date[0];
	mm=1*arr_date[1];
	yy=1*arr_date[2];
	if (yy<1900) yy=yy+1900;
	if (mm>12) mm=12;
	var tempdate = new Date(yy,mm-1,1);
	var curdate = new Date();
	wdstart=tempdate.getDay(); // ## dnya nedeli v 1 den mesyatsa	
	if (wdstart==0) wdstart=7;
	
	doc=obj_calwindow.document;
	doc.clear(); // make it empty !!!
	doc.write('<HTML><HEAD><META http-equiv=Content-Type content="text/html; charset=windows-1251"><TITLE> алендарь</TITLE><STYLE>');
	doc.write('TD {COLOR: #000; FONT: 10px verdana,arial; text-align: center}');	
	doc.write('A:link {	COLOR: #06c; TEXT-DECORATION: none}');
	doc.write('A:visited {COLOR: #039; TEXT-DECORATION: none}');
	doc.write('A:hover {COLOR: #d57919; TEXT-DECORATION: underline}');	
	doc.write('</STYLE></HEAD><BODY marginwidth=0 marginheight=0>');
	doc.write('\r\n<table width=100% border=1 cellspacing=0 cellpadding=0><tr>');
	forwardback(doc,this.id,1*yy,1*mm-1,"&lt;&lt;&lt;");
	doc.write('<td colspan=5>'+mounth_str[mm-1]+' '+yy+'</td>');
	forwardback(doc,this.id,1*yy,1*mm+1,"&gt;&gt;&gt;");
	doc.write('</td><tr bgcolor=lightblue><td>пн<td>вт<td>ср<td>чтв<td>птн<td>сб<td>вск</tr>');
	day=1;
	week=1;
	started=0;
	
	for (week=1;week<7;week++) {
		doc.write('<tr>');
		for (weekday=0;weekday<=6;weekday++) {
			wd=weekday+1;
			sdow='';
			if (weekday>=5) sdow=' bgcolor=#FFD0FF';
			if ((mm-1)==curdate.getMonth()) {
				if (day==curdate.getDate()) sdow=' bgcolor=#FFFF00';
			}
			doc.write('<td'+sdow+'>\r\n');
			if (wd==wdstart) { 
					if (started==0)	started=1; 
				}; 
			if (started==1) {
				writeday(doc,this.id,yy,mm,day,wd);
				//doc.write(day);
				day++;
			} // if started
			else {
				doc.write('&nbsp;');
			}; // empty section
			if (day>27) {
				tempdate = new Date(yy,mm-1,day);
				//tempdate.setDate(day);
				if (tempdate.getDate()!=day) started=2;
				if (tempdate.getMonth()!=(mm-1)) started=2; 
				//if (tempdate.getYear()!=yy) started=2; 
			} // day > 27			
		} // for - weekday
		if (started==2) break; // not need empty week-line
	} // week
	doc.write('</table><br>');
	doc.write('</body></html>');
	doc.close();
    obj_calwindow.opener = window;
    obj_calwindow.focus();
}

