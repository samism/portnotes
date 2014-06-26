from bottle import route, run, template, get, post, request, error, static_file, redirect, response

from random import *

import MySQLdb 
import hashlib, uuid
import smtplib
import string, re, time
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

from config import *

class PortApp(object):
  def __init__(self):
    self.alert_html = self.open_file('html/alert.html')
    self.valid_keys = []
    self.db_connect()

  def open_file(self, path):
    f = open(path, 'rU')
    contents = f.read()
    f.close()
    return contents

  def db_connect(self):
    try:
      self.db = portnotes_db
      self.cur = self.db.cursor() 
    except Exception, e:
      print "Database error: %s" % str(e)

  '''Random password is generated'''
  def generate_pass(self):
    characters = string.ascii_letters + string.digits
    password =  "".join(choice(characters) for x in range(randint(8, 16)))
    return password

  def send_email(self, toaddr, subject, txt, html):
    msg = MIMEMultipart('alternative')
    msg['Subject'] = subject
    msg['From'] = fromaddr
    msg['To'] = toaddr

    part1 = MIMEText(txt, 'plain')
    part2 = MIMEText(html, 'html')
  
    msg.attach(part1)
    msg.attach(part2)

    mail = smtplib.SMTP('smtp.gmail.com', 587)
    mail.ehlo()
    mail.starttls()
    mail.login(fromaddr, fromaddrpass)
    mail.sendmail(fromaddr, toaddr, msg.as_string())
    mail.quit()

  def server_css(self, filename):
    return static_file(filename, root='css')

  def server_img(self, filename):
    return static_file(filename, root='img')

  def server_html(self, filename):
    return static_file(filename, root='html')

  def server_js(self, filename):
    return static_file(filename, root='js')

  def server_fonts(self, filename):
    return static_file(filename, root='fonts')

  def logged_routes(self, filename):
    user_email = request.get_cookie("account")  
    if user_email and self.logged_in(user_email):
      return self.open_file(filename)
    else:
      return re.sub('">alert_here', ' alert-danger">You are not logged in.', self.alert_html)

  def home(self):
    return self.logged_routes('html/dash.html')

  def settings(self):
    return self.logged_routes('html/settings.html')

  def do_settings(self):
    user_email = request.get_cookie("account")
    original_pass = request.forms.get('pass')
    new_pass = request.forms.get('newpass')
    
    if self.check_login(user_email, original_pass):
      try:
        self.cur.execute("update users set user_password_hash = '%s' where user_email = '%s'" % (hashlib.sha512(new_pass).hexdigest(), user_email))
        self.db.commit()
        return re.sub('">alert_here', ' alert-success">Congratulations, password has successfully been updated.', self.alert_html)
      except Exception, e:
        return re.sub('">alert_here', ' alert-danger">Could not change password: ' + str(e), self.alert_html)
    return re.sub('">alert_here', ' alert-danger">Sorry, incorrect password entered.', self.alert_html)

  def update_loggedin(self, email):
    try:
      self.cur.execute("update users set logged_in = '%s' where user_email = '%s'" % (0, email))
      self.db.commit()
    except Exception, e:
      "Database Error: %s" % str(e)

  def login(self):
    email = request.get_cookie("account")
    response.delete_cookie("account")
    try:
      self.update_loggedin(email)
    except MySQLdb.OperationalError, e:
      self.db_connect()
      self.update_loggedin(email)

    login_page = open('html/index.html', 'rU').read()
    return login_page

  def do_login(self):
    username = request.forms.get('login')
    password = request.forms.get('password')
    if self.check_login(username, password):
      if self.check_active(username):
        response.set_cookie("account", username)
        last_time = time.strftime("%Y/%m/%d %H:%M:%S")
        self.cur.execute("update users set logged_in = '%s' where user_email = '%s'" % (1, username))
        self.db.commit()
        self.cur.execute("update users set last_seen = '%s' where user_email = '%s'" % (last_time, username))
        self.db.commit()
        redirect('/home')
      else:
        key = str(uuid.uuid4())[:10]
        validate_link = "samism.net:8080/validate/%s/%s" % (username, key)
        self.valid_keys.append(key)
        subject = "Confirm your email address"
        txt = "You are receiving this message because you need to validate your existing email address. Just click the link below and you're done. Link: %s" % (validate_link)
        html = """\
        <html>
        <head><head>
        <body>
        <p>You are receiving this message because you need to validate your existing email address for <i>Portnotes</i>. Just click the link below and you're done.<br>
        Link: <a href="http://%s">http://%s</a><br>
        </p>
        </body>
        </html>
        """ % (validate_link, validate_link)
        self.send_email(username, subject, txt, html)
        return re.sub('">alert_here', ' alert-danger">You must first verify your email. An email has been sent to your address.', self.alert_html)
    else:
        return re.sub('">alert_here', ' alert-danger">Login failed.', self.alert_html)

  def show_userinfo(self):
    self.cur.execute("select * from users")

    result = {}
    for row in self.cur.fetchall() :
      result[row[1]] = row[2]
    return result

  def check_login(self, name, passwd):
    userinfo = self.show_userinfo()
    return (name in userinfo and userinfo[name] == hashlib.sha512(passwd).hexdigest())
      
  def check_active(self, name):
    self.cur.execute("select is_active from users where user_email = '%s'" % name)
    fetched = self.cur.fetchall()
    return int(fetched[0][0])

  def logged_in(self, name):
    self.cur.execute("select logged_in from users where user_email = '%s'" % name)
    fetched = self.cur.fetchall()
    return int(fetched[0][0])

  def register(self):
    register_page = self.open_file('html/registration.html')
    return register_page

  def do_register(self):
    username = request.forms.get('email')
    password = request.forms.get('password')
    try:
      self.cur.execute("insert into users(user_email, user_password_hash) values ('%s', '%s')" % (username, hashlib.sha512(password).hexdigest()))
      self.db.commit()
      return self.open_file('html/success_reg.html')
    except Exception, e:
      return re.sub('">alert_here', ' alert-danger">Error with registration: ' + str(e), self.alert_html)

  def check_key(self, email, valid_key):
    if valid_key in self.valid_keys:
      self.cur.execute("update users set is_active = '%s' where user_email = '%s'" % (1, email))
      self.db.commit()
      self.valid_keys.remove(valid_key)
      return re.sub('">alert_here', ' alert-success">Congratulations, your account has been successfully verified.', self.alert_html)

    else:
      return self.error404('')

  def forgotpass(self):
    forgotpass_page = self.open_file('html/forgot.html')
    return forgotpass_page

  def sendpass(self):
    email = request.forms.get('login')
    new_pass = self.generate_pass()
    userinfo = self.show_userinfo()
    if email in userinfo: 
      try:
        self.cur.execute("update users set user_password_hash = '%s' where user_email = '%s'" % (hashlib.sha512(new_pass).hexdigest(), email))
        self.db.commit()
        subject = "Password Request"
        txt = "You are receiving this message because you asked to recover your password for Portnotes.\n\nYour login information is as follows:\nE-mail Address:  %s\nTemporary Password: %s (We highly recommend you change this!)\n\nYou can log in at: samism.net:8080" % (email, new_pass)
        html = """\
        <html>
        <head><head>
        <body>
        <p>You are receiving this message because you asked to recover your password for <i>Portnotes</i><br><br>Your login information is as follows:<br>
        E-mail Address: %s<br>
        Temporary Password: %s<br>
        <b><i>We highly recommend you change this!</b></i><br><br>
        You can log in at <a href="http://samism.net:8080">samism.net:8080</a>
        </p>
        </body>
        </html>
        """ % (email, new_pass)
        self.send_email(email, subject, txt, html)
        return re.sub('">alert_here', ' alert-success">Successful, an email has been sent with your password', self.alert_html)
      except Exception, e:
        return re.sub('">alert_here', ' alert-danger">Error: not a valid email address. %s' % str(e), self.alert_html)
    else:
      return re.sub('">alert_here', ' alert-danger">Error: not a valid email address', self.alert_html)

  def error404(self, error):
    return self.open_file('html/404.html')

'''Routes'''
portapp = PortApp()

route("/css/<filename>")(portapp.server_css)
route("/img/<filename>")(portapp.server_img)
route("/html/<filename>")(portapp.server_html)
route("/js/<filename>")(portapp.server_js)
route("/fonts/<filename>")(portapp.server_fonts)
route("/")(portapp.login)
get("/login")(portapp.login)
post("/login")(portapp.do_login)
get("/register")(portapp.register)
post("/register")(portapp.do_register)
route("/validate/<email>/<valid_key>")(portapp.check_key)
get("/forgotpass")(portapp.forgotpass)
post("/forgotpass")(portapp.sendpass)
route("/home")(portapp.home)
get("/settings")(portapp.settings)
post("/settings")(portapp.do_settings)

error(404)(portapp.error404)

run(host='162.243.231.223', port=8080, debug=True, reloader=True)
#run(host='localhost', port=8080, debug=True, reloader=True)

