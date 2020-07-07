-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 07, 2020 at 01:04 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `2240214_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `idAuthor` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `ts` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `idAuthor`, `state`, `title`, `content`, `ts`) VALUES
(7, 'admin', 'Published', 'Neque porro quisquam est qui dolore', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc semper sapien ac hendrerit facilisis. Pellentesque interdum justo sit amet nulla sagittis egestas. Maecenas vitae ipsum scelerisque, maximus tortor et, mollis orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Duis fringilla molestie nulla, non tincidunt mauris scelerisque at. In vel diam consequat, iaculis ipsum vel, volutpat dui. In hac habitasse platea dictumst. Integer sit amet turpis vitae dui ultrices lobortis vel non lacus. Aenean euismod nibh at ex elementum, nec dapibus metus gravida. Proin convallis mattis nisi, ut mollis justo pellentesque sed. Aliquam convallis felis tortor, ut blandit lectus malesuada non. Pellentesque hendrerit erat a leo ullamcorper facilisis.\n\nVivamus convallis laoreet est ut cursus. Sed sit amet ex vel odio vestibulum finibus vitae eget augue. Ut quis ultricies enim, ac ultricies arcu. Quisque interdum varius libero sagittis semper. Pellentesque pharetra faucibus lacus sed tristique. Aenean finibus sed odio at elementum. Maecenas blandit, lorem non faucibus porta, est arcu sodales massa, et vestibulum nisl tortor in purus. Ut vulputate urna dolor, sed viverra sapien cursus eu. Etiam consequat nisi elit, sed finibus enim volutpat eget. Cras lacus massa, tristique vitae massa in, luctus iaculis mi. Donec vehicula eget lorem at convallis. Nullam fringilla dolor nec facilisis vehicula. Fusce lobortis a dui nec scelerisque. Aenean ac placerat enim.', '2020-07-07 00:36:30'),
(8, 'admin', 'Published', 'Vivamus convallis laoreet est ut cursus.', 'Suspendisse euismod sapien libero, non fringilla lectus tincidunt et. Praesent pharetra dolor a tellus pellentesque, ut ultricies magna consequat. Aliquam consequat consectetur nibh, eu hendrerit diam consequat vitae. Ut porta ornare finibus. Vestibulum elementum dui diam, ut bibendum urna ultrices sed. Phasellus sollicitudin molestie arcu commodo dictum. Integer ligula metus, tristique a risus quis, lacinia consectetur nisi. Nulla arcu diam, bibendum a sapien a, finibus dictum mauris. Cras massa tellus, mattis id justo ac, pulvinar tincidunt mi. Aenean eu viverra mi. Sed accumsan id velit sit amet sollicitudin. Nunc accumsan cursus purus, fringilla posuere ipsum varius non. Sed pharetra dolor eget massa tincidunt, tempor finibus ante sodales. Integer maximus eros sit amet malesuada eleifend.', '2020-07-07 13:00:00'),
(10, 'admin', 'Published', 'Lorem Ipsum Dolo sit Amet', 'Us%20sollicitudin%20molestie%20arcu%20commodo%20dictum.%20Integer%20ligula%20metus,%20tristique%20a%20risus%20quis,%20lacinia%20consectetur%20nisi.%20Nulla%20arcu%20diam,%20bibendum%20a%20sapien%20a,%20finibus%20dictum%20mauris.%20Cras%20massa%20tellus,%20mattis%20id%20justo%20ac,%20pulvinar%20tincidunt%20mi.%20Aenean%20eu%20viverra%20mi.%20Sed%20accumsan%20id%20velit%20sit%20amet%20sollicitudin.%20Nunc%20accumsan%20cursus%20purus,%20%0A%0A%0AFringilla%20posuere%20ipsum%20varius%20non.%20Sed%20pharetra%20dolor%20eget%20massa%20tincidunt,%20tempor%20finibus%20ante%20sodales.%20Integer%20maximus%20eros%20sit%20amet%20malesuada%20eleifend.', '2020-07-07 00:48:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `timestamp`) VALUES
(1, 'admin', 'admin', '2018-04-20 16:23:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
