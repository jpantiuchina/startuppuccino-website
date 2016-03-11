package com.startuppuccino.projects;

import com.startuppuccino.accounts.Account;
import org.springframework.data.jpa.repository.JpaRepository;



public interface ProjectAccountRepository extends JpaRepository<ProjectAccount, Integer>
{
    ProjectAccount findOneByProjectAndAccount(Project project, Account account);


}
