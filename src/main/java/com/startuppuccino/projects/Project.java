package com.startuppuccino.projects;

import javax.persistence.*;

import java.util.List;
import org.hibernate.validator.constraints.Length;
import org.hibernate.validator.constraints.NotEmpty;



@Entity
public class Project
{
    @Id
    @GeneratedValue
    private int id;

    @NotEmpty
    @Length(max = 63)
    private String title;

    @Lob
    private String description;

    @OneToMany(mappedBy = "project")
    private List<ProjectAccount> accounts;




    public int getId()
    {
        return id;
    }


    public String getTitle()
    {
        return title;
    }


    public void setTitle(String title)
    {
        this.title = title;
    }


    public String getDescription()
    {
        return description;
    }


    public void setDescription(String description)
    {
        this.description = description;
    }
}
