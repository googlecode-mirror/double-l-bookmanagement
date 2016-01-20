需求:
```
1. 有總管理處與分校需求. 希望用A-Z來作為代碼
2. 總管理處可以看到分校管理, 分校只能看到自己的分校. 
3. 老師可以跨校借閱. 
4. 書籍編碼 [A-Z][5d][2d]
   [A-Z] 為分校代碼
   [5d] 為流水號
   [2d] 為書本數量編號

5.要有盤點功能, 當啓動盤點功能時, 不能進行借閱,歸還, 續借.
  盤點功能由分校自行啟動
6.提供email 續借與逾期通知
7.書本標簽列印功能
  每一個標籤 30x70mm
  要有色塊, 區分書籍等級
```

解法
```
登入角色: 
   admin : 全部都有
   localadmin : 書本出借, 密碼修改, 盤點啓動
   localmanager : 書本查詢與預約
   user : 書本查詢與預約
職務名稱:
   Schema =>
      id : 
      name : 職務名稱

借閱等級:
   Schema =>
      id : 借閱等級ID
      Name : 名稱
      lead_days : 借閱天數
      lead_count : 借閱數量
      is_cross_lead : 跨校借閱
群組 : 
   Schema =>
      id : 群組id
      org_id: 組織id
      group_name: 群組名稱
      create_time:
```

```
4. 書籍編碼: 
   [A-Z] :由書本分校設定得來
   [5d]  :由書本資訊流水編號
   [2d]  :Select count(*) from book_instances Where s_id and book_id
```


login Info
```
  使用者登入後, 會在Session 紀錄下列資料
  1. user_id : 使用者代號
  2. user_name : 使用者名稱
  3. user_role :  使用者角色
  4. user_location : 使用者分校代碼
```