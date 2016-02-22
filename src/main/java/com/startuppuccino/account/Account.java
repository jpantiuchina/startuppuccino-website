package com.startuppuccino.account;

import javax.persistence.*;

import java.time.Instant;
import org.hibernate.validator.constraints.Email;
import org.hibernate.validator.constraints.Length;
import org.hibernate.validator.constraints.NotEmpty;



@Entity
@Table(name = "account",
        uniqueConstraints = @UniqueConstraint(name = "account_email", columnNames = "email"))
public class Account
{
    public void setId(int id)
    {
        this.id = id;
    }


    public boolean isHasAvatar()
    {
        return avatar != null;
    }


    public enum Role {ROLE_USER, ROLE_MENTOR, ROLE_ADMIN}

//    public static final String ROLE_USER   = "ROLE_USER";
//    public static final String ROLE_MENTOR = "ROLE_MENTOR";
//    public static final String ROLE_ADMIN  = "ROLE_ADMIN";

    @Id
    @GeneratedValue
    private int id;

    @Email
    @NotEmpty
    @Column(length = 63)
    private String email;

    @NotEmpty
    @Length(max = 63)
    private String password;

    @Column(nullable = false, length = 15)
    @Enumerated(EnumType.STRING)
    private Role role = Role.ROLE_USER;

    @Column(nullable = false)
    private Instant created;

    @NotEmpty
    @Length(max = 63)
    private String firstName;

    @NotEmpty
    @Length(max = 63)
    private String lastName;

    @NotEmpty
    @Length(max = 255)
    private String background;

    @Lob
    private byte[] avatar;

    @Lob
    private String about;




    public int getId()
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


    public Role getRole()
    {
        return role;
    }


    public void setRole(Role role)
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


    public String getFirstName()
    {
        return firstName;
    }


    public void setFirstName(String firstName)
    {
        this.firstName = firstName;
    }


    public String getLastName()
    {
        return lastName;
    }


    public void setLastName(String lastName)
    {
        this.lastName = lastName;
    }


    public String getBackground()
    {
        return background;
    }


    public void setBackground(String background)
    {
        this.background = background;
    }


    public boolean getIsMentor()
    {
        return getRole() == Role.ROLE_MENTOR;
    }

    public boolean getIsAdmin()
    {
        return getRole() == Role.ROLE_ADMIN;
    }

    public boolean getIsUser()
    {
        return getRole() == Role.ROLE_USER;
    }

    public byte[] getAvatar()
    {
        return avatar;
    }

    public void setAvatar(byte[] avatar)
    {
        this.avatar = avatar;
    }


    public String getAbout()
    {
        return about;
    }


    public void setAbout(String about)
    {
        this.about = about;
    }
}
