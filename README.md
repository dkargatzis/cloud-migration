# cloud-migration
Cloud migration project is a platform that allows you to migrate a virtual machine between two Homogeneous but also  Heterogeneous Cloud Environments. The project utilizes the Openstack’s and VMware’s REST API to allow users to perform migration.
<br><br>
Specifically you can transfer a virtual machine from <a href="http://cloud.intellicloud.tuc.gr/">Intellicloud</a> to <a href="https://cloud.lab.fiware.org/">FIWARE Lab</a> (Homogeneous scenario), or from <a href="https://cloud.lab.fiware.org/">FIWARE Lab</a> to <a href="http://www.stratogen.net">StratoGen</a> (Heterogoneous scenario).

<h3>Prerequisites</h3>

<ul>
  <li>a Linux distribution</li>
  <li><a href="http://www.qemu.org/">Qemu</a> command-line tool, is an open source machine emulator and virtualizer.</li>
  <li>Curl (Client URL Library) for PHP</li>
  <li>Fiware account</li>
  <li>Intellicloud account</li>
  <li>StratoGen account</li>
</ul>

<h3>Getting Started</h3>

Clone `cloud-migration` repository to your server.
<br>
Change `assets` folder permissions to `rw-`
<br>
Now browse to the app at `server-ip/cloud-migration`

###Use `cloud-migration`

Browse at <a href="http://147.27.60.220/migration/">cloud-migration</a>
