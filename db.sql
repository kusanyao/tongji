create database tongji;

use tongji;

CREATE TABLE `tongji` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `domain` varchar(50) NOT NULL COMMENT 'domain',
  `url` varchar(512) NOT NULL COMMENT 'url',
  `title` varchar(255) NOT NULL COMMENT 'title',
  `referrer` varchar(255) NOT NULL DEFAULT '' COMMENT 'referrer',
  `ip` int unsigned not null DEFAULT 0 COMMENT 'ip',
  `guid` char(36) not null DEFAULT '' COMMENT 'guid',
  `count` int unsigned not null DEFAULT 0 COMMENT 'guid',
  `useragent` varchar(255) NOT NULL DEFAULT '' COMMENT 'user agent',
  `platform` varchar(255) NOT NULL DEFAULT '' COMMENT 'platform',
  `height` smallint unsigned NOT NULL DEFAULT 0 COMMENT 'height',
  `width` smallint unsigned NOT NULL DEFAULT 0 COMMENT 'width',
  `colordepth` tinyint unsigned NOT NULL DEFAULT 0 COMMENT 'cd',
  `language` varchar(255) NOT NULL DEFAULT '' COMMENT 'language',
  `created_at` int unsigned NOT NULL COMMENT 'created_at',
  PRIMARY KEY (`id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='tongji';

-- pv
select url,count(id) as pv from tongji 
WHERE url='http://tongji.kusanyao.com/index.html';

select url,count(id) from tongji 
WHERE url like 'http://tongji.kusanyao.com/index.html%'
group by url;

-- ip
select url,count(DISTINCT ip) as ip from tongji
where url='http://tongji.kusanyao.com/index.html'
group by ip;

select url,count(DISTINCT url,ip) as ip from tongji
where url like 'http://tongji.kusanyao.com/index.html%'
group by url;

-- uv
select url,count(guid) as uv from tongji
where url='http://tongji.kusanyao.com/index.html';

select  url,count(DISTINCT url,guid) as uv from tongji
where url like 'http://tongji.kusanyao.com/index.html%'
GROUP BY url;