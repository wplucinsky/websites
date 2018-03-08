# Websites

## droger
### Example
Viewable here* https://rawgit.com/wplucinsky/websites/master/droger/index.html

### Setup
- clone directory/upload to webserver
- generate `.env` file with MySQL server name (`servername`), username (`username`), password (`pwd`), and database name (`dbname`)
- create the `collage` table 
```
CREATE TABLE `collage` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `imgname` varchar(150) CHARACTER SET utf8 NOT NULL,
 `orig_width` int(11) NOT NULL,
 `orig_height` int(11) NOT NULL,
 `new_width` int(11) NOT NULL,
 `new_height` int(11) NOT NULL,
 `inserted_at_val` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `softdelete` tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1
```
- navigate to `src/scripts/collage.php` to upload JPEG and PNG images

* PHP code will not execute on `rawgit.com`
