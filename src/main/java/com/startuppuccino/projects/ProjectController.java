package com.startuppuccino.projects;

import javax.validation.Valid;

import com.startuppuccino.accounts.Account;
import com.startuppuccino.accounts.AccountService;
import java.security.Principal;
import org.hibernate.Hibernate;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.stereotype.Controller;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;



@Controller
@RequestMapping("/projects")
public class ProjectController
{
    @Autowired
    private ProjectRepository projectRepository;

    @Autowired
    private ProjectAccountRepository projectAccountRepository;

    @Autowired
    private AccountService accountService;


    @RequestMapping(method = RequestMethod.GET)
    public String index(Model model)
    {
        model.addAttribute(projectRepository.findAll());
        return "projects/index";
    }


    @Transactional
    @RequestMapping(value = "/{id}", method = RequestMethod.GET)
    public String project(@PathVariable("id") int id, Principal principal, Model model)
    {
        Project project = projectRepository.getOne(id);
        Hibernate.initialize(project.getAccounts());
        for (ProjectAccount projectAccount : project.getAccounts())
            Hibernate.initialize(projectAccount.getAccount());


        model.addAttribute(project);

        if (principal != null)
        {
            Account account = accountService.getCurrentAccount(principal);
            ProjectAccount projectAccount = projectAccountRepository.findOneByProjectAndAccount(project, account);
            if (projectAccount != null)
                model.addAttribute(projectAccount);
        }

        return "projects/project";
    }


    @PreAuthorize("hasAnyRole('ROLE_USER', 'ROLE_MENTOR', 'ROLE_ADMIN')")
    @RequestMapping(value = "/add", method = RequestMethod.GET)
    public String add(Model model)
    {
        model.addAttribute(new Project());
        return "projects/project-form";
    }


    @PreAuthorize("hasAnyRole('ROLE_USER', 'ROLE_MENTOR', 'ROLE_ADMIN')")
    @RequestMapping(value = "/add", method = RequestMethod.POST)
    public String add(@Valid Project project, BindingResult bindingResult)
    {
        if (bindingResult.hasErrors())
            return "projects/project-form";
        project = projectRepository.saveAndFlush(project);
        return "redirect:/projects/" + project.getId();
    }


    @Transactional
    @PreAuthorize("hasAnyRole('ROLE_USER', 'ROLE_MENTOR', 'ROLE_ADMIN')")
    @RequestMapping(value = "/{id}/edit", method = RequestMethod.GET)
    public String edit(@PathVariable("id") int id, Model model)
    {
        Project project = projectRepository.getOne(id);
        Hibernate.initialize(project);
        model.addAttribute(project);
        return "projects/project-form";
    }


    @PreAuthorize("hasAnyRole('ROLE_USER', 'ROLE_MENTOR', 'ROLE_ADMIN')")
    @RequestMapping(value = "/{id}/edit", method = RequestMethod.POST)
    public String edit(@PathVariable("id") int id, @Valid Project project, BindingResult bindingResult)
    {
        project.setId(id);
        if (bindingResult.hasErrors())
            return "projects/project-form";
        project = projectRepository.saveAndFlush(project);
        return "redirect:/projects/" + project.getId();
    }





    @PreAuthorize("hasAnyRole('ROLE_USER', 'ROLE_MENTOR')")
    @RequestMapping(value = "/{id}/join", method = RequestMethod.POST)
    public String join(@PathVariable("id") int id, Principal principal)
    {
        Account account = accountService.getCurrentAccount(principal);
        Project project = projectRepository.getOne(id);

        ProjectAccount projectAccount = new ProjectAccount();
        projectAccount.setAccount(account);
        projectAccount.setProject(project);

        projectAccountRepository.saveAndFlush(projectAccount);
        return "redirect:/projects/" + id;
    }


    @PreAuthorize("hasAnyRole('ROLE_USER', 'ROLE_MENTOR')")
    @RequestMapping(value = "/{id}/leave", method = RequestMethod.POST)
    public String leave(@PathVariable("id") int id, Principal principal)
    {
        Account account = accountService.getCurrentAccount(principal);
        Project project = projectRepository.getOne(id);

        ProjectAccount projectAccount = projectAccountRepository.findOneByProjectAndAccount(project, account);
        projectAccountRepository.delete(projectAccount);

        return "redirect:/projects/" + id;
    }




}
