
Name: app-web-server
Epoch: 1
Version: 2.5.0
Release: 1%{dist}
Summary: Web Server
License: GPLv3
Group: Applications/Apps
Packager: ClearFoundation
Vendor: ClearFoundation
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base
Requires: app-accounts
Requires: app-certificate-manager
Requires: app-groups
Requires: app-users
Requires: app-network
Requires: app-php-core >= 1:1.4.40

%description
The Web Server app can be used to create simple standalone web sites or as part of a broader infrastructure to deploy web-based applications using technologies like PHP, MySQL, and JavaScript.

%package core
Summary: Web Server - API
License: LGPLv3
Group: Applications/API
Requires: app-base-core
Requires: app-certificate-manager-core >= 1:2.4.5
Requires: app-network-core >= 1:2.4.2
Requires: app-flexshare-core >= 1:2.4.5
Requires: httpd >= 2.2.15
Requires: mod_authnz_external
Requires: mod_authz_unixgroup
Requires: mod_ssl
Requires: openssl >= 1.0.1e-16.el6_5.7
Requires: perl-CGI
Requires: pwauth
Requires: syswatch >= 6.2.3

%description core
The Web Server app can be used to create simple standalone web sites or as part of a broader infrastructure to deploy web-based applications using technologies like PHP, MySQL, and JavaScript.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/web_server
cp -r * %{buildroot}/usr/clearos/apps/web_server/

install -d -m 0755 %{buildroot}/var/clearos/web_server
install -d -m 0755 %{buildroot}/var/clearos/web_server/backup
install -d -m 0755 %{buildroot}/var/www/virtual
install -D -m 0644 packaging/filewatch-web-server-configuration.conf %{buildroot}/etc/clearsync.d/filewatch-web-server-configuration.conf
install -D -m 0644 packaging/httpd.php %{buildroot}/var/clearos/base/daemon/httpd.php

%post
logger -p local6.notice -t installer 'app-web-server - installing'

%post core
logger -p local6.notice -t installer 'app-web-server-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/web_server/deploy/install ] && /usr/clearos/apps/web_server/deploy/install
fi

[ -x /usr/clearos/apps/web_server/deploy/upgrade ] && /usr/clearos/apps/web_server/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-web-server - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-web-server-core - uninstalling'
    [ -x /usr/clearos/apps/web_server/deploy/uninstall ] && /usr/clearos/apps/web_server/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/web_server/controllers
/usr/clearos/apps/web_server/htdocs
/usr/clearos/apps/web_server/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/web_server/packaging
%exclude /usr/clearos/apps/web_server/unify.json
%dir /usr/clearos/apps/web_server
%dir /var/clearos/web_server
%dir /var/clearos/web_server/backup
%dir /var/www/virtual
/usr/clearos/apps/web_server/deploy
/usr/clearos/apps/web_server/language
/usr/clearos/apps/web_server/libraries
/etc/clearsync.d/filewatch-web-server-configuration.conf
/var/clearos/base/daemon/httpd.php
