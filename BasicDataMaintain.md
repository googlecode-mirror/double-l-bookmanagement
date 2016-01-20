# 書籍資料 #

  * 書籍基本資料
```
    Table Name : Books
    Columns :  
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '書籍編號',
    `book_type` varchar(5) NOT NULL COMMENT '書籍類型 (B:書, M:期刊)',
    `book_name` varchar(200) NOT NULL COMMENT 'B:書籍名稱, M:期刊名稱',
    `book_author` varchar(100) NOT NULL COMMENT 'B:作者 M:',
    `book_publisher` varchar(100) NOT NULL COMMENT '出版商',
    `cate_id` int(11) NOT NULL COMMENT '書籍分類',
    `isbn` varchar(20) NOT NULL COMMENT 'B:ISBN, M:ISSN',
    `book_version` varchar(20) NOT NULL COMMENT 'B:版別, M:刊期',
    `book_search_code` varchar(100) NOT NULL COMMENT 'B:索書號 M:',
    `book_location` varchar(100) NOT NULL COMMENT 'B:櫃別 M:',
    `book_attachment` varchar(100) NOT NULL COMMENT 'B:附屬媒體',
    `publish_date` date NOT NULL COMMENT 'B:出版日期, M:創刊日',
    `order_start_date` date NOT NULL COMMENT 'B: M:訂購開始日期',
    `order_end_date` date NOT NULL COMMENT 'B: M:訂購結束日期',
    `order_start_version` int(11) NOT NULL COMMENT 'B: M:訂購開始期數',
    `order_end_version` int(11) NOT NULL COMMENT 'B: M:訂購結束期數',
    `memo` text NOT NULL COMMENT '備註',
    `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '登記日期',

         
```

  * 書籍實體資料
```
    Table Name : Book_Instances
    Columns :
      `id` VARCHAR( 20 ) NOT NULL ,
      `book_id` INT NOT NULL ,
      `book_version` VARCHAR( 10 ) NULL COMMENT ' B:, M:期刊數',
      `purchase_price` INT NULL COMMENT '購買金額',
      `book_status` VARCHAR( 10 ) COMMENT '書籍狀態' ,
      `person_level` INT NOT NULL COMMENT '借閱等級',
      `purchase_date` DATE NOT NULL COMMENT 'B:購買日, M:發行日期' ,
      `is_lend` VARCHAR( 10 ) NOT NULL COMMENT 'Y/N',
      `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登記日期',

```



  * 書籍基本資料
```
    Table Name : Book_Basics
    Columns :
       id : 書籍基本資料編號
       book_type : 書籍類型 (0:書, 1:期刊)
       book_name : 書籍名稱
       book_author : 作者
       book_publisher : 出版商
       cate_id : 書籍分類
       publish_date : 出版日期
       create_date : 登記日期
```
  * 書籍版別資料
```
    Table Name : Book_Versions
    Columns :
       id : 書籍版別資料編號
       basic_id : 書籍基本資料編號
       isbn : ISBN (根據定義有時版別不同會有不同ISBN)
       book_version : 版別
       book_search_code : 索書號
       book_location : 櫃別
       publish_date : 出版日期
       create_date : 登記日期
```

  * 書籍資料資料
```
    Table Name : Books
    Columns :
       id : 書籍編號
       version_id : 書籍版別資料編號
       purchase_price : 購買金額
       book_status : 狀態
       person_level : 借閱等級
       purchase_date : 購入日期
       valid
       create_date : 登記日期
```
  * 書籍分類資料
```
    Table Name : Book_Catagorys
    Columns :
       id : 分類號
       catagory_name : 分類名稱
       create_date : 登記日期
```
  * 出版公司資料
```
    Table Name : Book_Publishers
    Columns :
       id : 公司編號
       address : 地址
       phone : 電話
       fax : 傳真
       sales : 業務
       mobile_phone : 行動電話
       memo : 備註
```
  * 期刊雜誌基本資料

# 人員資料 #
  * 借閱者資本資料
```
    Table Name : Persons
    Columns :
       id : 卡號
       name : 姓名
       gender : 性別
       social_id : 身份證
       birthday : 生日
       title_id : 職稱
       group_id : 群組
       phone : 聯絡電話
       home_phone : 住家電話
       mobile_phone : 行動電話
       fax : 傳真電話
       email : 電子郵件
       address : 通訊地址
       memo : 備註
       level_id : 借閱等級
       password : 查詢密碼
       create_date : 建立日期
       card_create_date : 發卡日期
       card_return_date : 退卡日期
       card_create_count : 補卡次數
       card_reissue_date : 補卡日期
```
  * 群組資料
```
    Table Name : Person_Groups
    Columns :
       group_id : 分類號
       group_name : 分類名稱
       create_date : 登記日期
```
  * 等級權限資料
```
    Table Name : Person_Levels
    Columns :
       level_id : 分類號
       level_name : 分類名稱
       max_day : 借閱天數
       max_book : 借閱書籍
       create_date : 登記日期
```
  * 職務名稱
```
    Table Name : Person_Titles
    Columns :
       title_id : 職務代碼
       title_name : 職務名稱
       create_date : 登記日期
```