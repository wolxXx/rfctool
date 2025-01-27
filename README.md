# rfctool
manage rfcs, the easy way

php8.4
mariadb

add user
user: id, email, password, status (active, blocked), created at
passkeys: public key, user id, created at

entry: title, status (prepare, review, open for voting, voting closed, rejected, accepted, obsolete), parent, body
entry_authors: entry_id, user_id, primary

vote: entry_id, user_id, date, reason, result (-1,0,1) => -1 = rejected, 0 = neutral, 1 = approved

group: name
user_groups: group_id, user_id

