/*
 Navicat Premium Data Transfer

 Source Server         : testing
 Source Server Type    : MySQL
 Source Server Version : 50731
 Source Host           : localhost:3306
 Source Schema         : tictac

 Target Server Type    : MySQL
 Target Server Version : 50731
 File Encoding         : 65001

 Date: 25/08/2022 17:42:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for game_histories
-- ----------------------------
DROP TABLE IF EXISTS `game_histories`;
CREATE TABLE `game_histories`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) UNSIGNED NOT NULL,
  `player_id` bigint(20) UNSIGNED NOT NULL,
  `box_id_x` int(3) NOT NULL,
  `box_id_y` int(3) NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `game_histories_game_id_foreign`(`game_id`) USING BTREE,
  INDEX `game_histories_player_id_foreign`(`player_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of game_histories
-- ----------------------------
INSERT INTO `game_histories` VALUES (17, 1, 1, 1, 2, 0, '2022-08-25 08:03:22', '2022-08-25 08:03:22');
INSERT INTO `game_histories` VALUES (16, 1, 2, 2, 0, 0, '2022-08-25 08:03:19', '2022-08-25 08:03:19');
INSERT INTO `game_histories` VALUES (15, 1, 1, 1, 0, 0, '2022-08-25 08:03:16', '2022-08-25 08:03:16');
INSERT INTO `game_histories` VALUES (14, 1, 2, 2, 2, 0, '2022-08-25 08:03:11', '2022-08-25 08:03:11');
INSERT INTO `game_histories` VALUES (13, 1, 1, 1, 1, 0, '2022-08-25 08:03:09', '2022-08-25 08:03:09');
INSERT INTO `game_histories` VALUES (12, 1, 2, 0, 1, 0, '2022-08-25 08:03:06', '2022-08-25 08:03:06');
INSERT INTO `game_histories` VALUES (11, 1, 1, 0, 0, 0, '2022-08-25 08:03:02', '2022-08-25 08:03:02');

-- ----------------------------
-- Table structure for games
-- ----------------------------
DROP TABLE IF EXISTS `games`;
CREATE TABLE `games`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bordLength` int(11) NOT NULL,
  `max_move` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Records of games
-- ----------------------------
INSERT INTO `games` VALUES (1, 3, 3, 1, NULL, '2022-08-25 08:02:58');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (2, '2022_08_24_045652_create_games_table', 1);
INSERT INTO `migrations` VALUES (3, '2022_08_24_045921_create_players_table', 1);
INSERT INTO `migrations` VALUES (4, '2022_08_24_045955_create_game_histories_table', 1);

-- ----------------------------
-- Table structure for players
-- ----------------------------
DROP TABLE IF EXISTS `players`;
CREATE TABLE `players`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sign` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `move_count` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `players_game_id_foreign`(`game_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of players
-- ----------------------------
INSERT INTO `players` VALUES (1, 1, 'Me', 'X', 0, 0, NULL, '2022-08-25 08:03:22');
INSERT INTO `players` VALUES (2, 1, 'You', '0', 0, 1, NULL, '2022-08-25 08:03:22');

SET FOREIGN_KEY_CHECKS = 1;
