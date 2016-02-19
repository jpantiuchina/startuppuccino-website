package com.startuppuccino.account;

import javax.persistence.*;
import javax.validation.constraints.NotNull;

import java.time.Instant;
import org.hibernate.validator.constraints.Email;
import org.hibernate.validator.constraints.NotEmpty;



@Entity
@Table(name = "account")
public class Account
{
    @Id
    @GeneratedValue
    private Long id;

    @Email
    @NotEmpty
    @Column(unique = true)
    private String email;

    @NotEmpty
    private String password;

    @Column(nullable = false)
    private String role = "ROLE_USER";

    @Column(nullable = false)
    private Instant created;


    protected Account()
    {

    }



    public Long getId()
    {
        return id;
    }


    public String getEmail()
    {
        return email;
    }


    public void setEmail(String email)
    {
        this.email = email;
    }


    public String getPassword()
    {
        return password;
    }


    public void setPassword(String password)
    {
        this.password = password;
    }


    public String getRole()
    {
        return role;
    }


    public void setRole(String role)
    {
        this.role = role;
    }


    public Instant getCreated()
    {
        return created;
    }


    public void setCreated(Instant created)
    {
        this.created = created;
    }
}
