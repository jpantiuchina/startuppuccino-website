package com.startuppuccino.account;

import java.util.List;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;


public interface AccountRepository extends JpaRepository<Account, Integer>
{
    Account findOneByEmail(String email);

}
