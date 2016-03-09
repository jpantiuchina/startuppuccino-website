package com.startuppuccino.accounts;

import org.springframework.data.jpa.repository.JpaRepository;


public interface AccountRepository extends JpaRepository<Account, Integer>
{
    Account findOneByEmail(String email);

}
