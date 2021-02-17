# Changelog

## 1.0.1 - 2019-10-07
- initial release
## 1.0.2 - 2019-10-07
- add Extra ServiceProvider for Laravel >= 5.5
- update Readme installation instruction
## 1.2.0 - 2019-10-21
- Add Translatable interface
## 1.3.0 - 2019-10-22
- Added Rule static helper for use in validation
- Added additional check of string rule by enum
- Fixed style of calling static methods in some package objects
## 1.3.5 - 2020-05-03
- Fix error equals enums in model
## 1.4.0 - 2020-05-20
- Add EnumList Trait
- Fix Enum Value Validation
## 1.4.1 - 2020-05-20
- Fix errors
## 1.4.2 - 2020-06-29
- Fix value setter enum
## 1.4.3 - 2020-06-30
- Fixed setter enum value type declaration
## 1.5.0 - 2021-01-13
- Create command Sync Enum local to DB.
## 1.5.1 - 2021-01-14
- Add support laravel 8.0
## 1.5.2 - 2021-01-18
- Create scope findByEnum(string $column, Enum $enum)
## 1.5.3 - 2021-01-25
- Fix error from ServiceProvider (thanks [dead23angel](https://github.com/dead23angel))
## 1.5.4 - 2021-02-17
- Fix error from get enum value and default setter
## 1.5.5 - 2021-02-17
- Fix error validator enum value