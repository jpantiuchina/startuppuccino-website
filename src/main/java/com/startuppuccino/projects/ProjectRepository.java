package com.startuppuccino.projects;

import org.springframework.data.jpa.repository.JpaRepository;



public interface ProjectRepository extends JpaRepository<Project, Integer>
{

}
