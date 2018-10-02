Date.prototype.formatDate = function(f) {
  if (!this.valueOf() || !f) return ' ';
  var t = this, zp = function(v) { return v < 10 ? '0' + v : v; },
    dArr = ['Pazar','Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi','Paz','Pzt','Sal','Çar','Per','Cum','Cmt'];

  return f.replace(/(yyyy|yy|mmmm|mmm|mm|m|dddd|ddd|dd|d|HH|MM|ss|l)/g,
    function($1) {
      switch ($1) {
        case 'yy': return ('' + t.getFullYear()).slice(-2);
        case 'yyyy': return t.getFullYear();
        case 'm': return t.getMonth() + 1;
        case 'mm': return zp(t.getMonth() + 1);
        case 'mmm': return mArr[t.getMonth() + 12];
        case 'mmmm': return mArr[t.getMonth()];
        case 'd': return t.getDate();
        case 'dd': return zp(t.getDate());
        case 'ddd': return dArr[t.getDay() + 7];
        case 'dddd': return dArr[t.getDay()];
        case 'HH': return zp(t.getHours());
        case 'MM': return zp(t.getMinutes());
        case 'ss': return zp(t.getSeconds());
        case 'l': return ('00' + t.getMilliseconds()).slice(-3);
      }
    });
}

String.prototype.parseDate = function(f) {
  if (!this.valueOf()) return ' ';
  var y = 0, m = 0, d = 0, H = 0, M = 0, s = 0, L = 0, t = this.split(/[-\/ .:]/);
  f = (!f ? 'yyyy-mm-dd HH:MM:ss' : f).split(/[-\/ .:]/);

  for (var k in f) {
    switch (f[k]) {
      case 'yy': y = '20' + t[k]; break;
      case 'yyyy': y = t[k]; break;
      case 'm':
      case 'mm': m = parseInt(t[k], 10) - 1; break;
      case 'mmm':
      case 'mmmm': if ((m = mArr.indexOf(t[k])) == -1) {return 'invalid month';} m %= 12; break;
      case 'd':
      case 'dd': d = t[k]; break;
      case 'ddd':
      case 'dddd': break;
      case 'H':
      case 'HH': H = t[k]; break;
      case 'M':
      case 'MM': M = t[k]; break;
      case 's':
      case 'ss': s = t[k]; break;
      case 'l': L = t[k]; break;
      default: return 'invalid format';
    }
  }
  return new Date(y, m, d, H, M, s, L);
}

String.prototype.convertDate = function(f1, f2) {
  if (!this.valueOf() || !f1 || !f2) return ' ';
  return this.parseDate(f1).formatDate(f2);
}

var mArr = ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık','Oca','Şub','Mar','Nis','May','Haz','Tem','Ağu','Eyl','Eki','Kas','Ara'];