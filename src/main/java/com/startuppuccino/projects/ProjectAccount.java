package com.startuppuccino.projects;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.ManyToOne;
import javax.persistence.Table;
import javax.persistence.UniqueConstraint;

import com.startuppuccino.accounts.Account;



@Entity
@Table(uniqueConstraints =  @UniqueConstraint(name = "project_account", columnNames = {"project_id", "account_id"}))
public class ProjectAccount
{
    @Id
    @GeneratedValue
    private int id;

    @ManyToOne(optional = false)
    private Project project;

    @ManyToOne(optional = false)
    private Account account;


    public int getId()
    {
        return id;
    }


    public Project getProject()
    {
        return project;
    }


    public void setProject(Project project)
    {
        this.project = project;
    }


    public Account getAccount()
    {
        return account;
    }


    public void setAccount(Account account)
    {
        this.account = account;
    }
}
