function includes(source,k) {
  for(var i=0; i < source.length; i++){
    if( source[i][0] === k || ( source[i][0] !== source[i][0] && k !== k ) ){
      return true;
    }
  }
  return false;
}
function addzeroes(data,target) 
{
	var newData = target;
	for (i = 1; i <= data.length; i++) {
		if(!includes(target,data[i-1][0]))
			target.push([data[i-1][0],0]);
	}
	return newData;
}

function sortFunction(a, b) {
    if (a[0] === b[0]) {
        return 0;
    }
    else {
        return (a[0] < b[0]) ? -1 : 1;
    }
}

function toHHMMSS(seconds) 
{
    var h, m, s, result='';
    // HOURs
    h = Math.floor(seconds/3600);
    seconds -= h*3600;
    if(h){
        result = h<10 ? '0'+h+':' : h+':';
    }
	else result='00:';
    // MINUTEs
    m = Math.floor(seconds/60);
    seconds -= m*60;
    result += m<10 ? '0'+m+':' : m+':';
    // SECONDs
    s=seconds%60;
    result += s<10 ? '0'+s : s;
   
    return result;
}